<?php
require('secure.inc.php');
if(!is_object($thisclient) || !$thisclient->isValid()) die('Access denied'); //Double check again.

if ($thisclient->isGuest())
    $_REQUEST['id'] = $thisclient->getTicketId();

require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.json.php');
$ticket=null;
if($_REQUEST['id']) {
    if (!($ticket = Ticket::lookup($_REQUEST['id']))) {
        $errors['err']=__('Unknown or invalid ticket ID.');
    } elseif(!$ticket->checkUserAccess($thisclient)) {
        $errors['err']=__('Unknown or invalid ticket ID.'); //Using generic message on purpose!
        $ticket=null;
    }
}

if (!$ticket && $thisclient->isGuest())
    Http::redirect('view.php');

$tform = TicketForm::objects()->one();
$messageField = $tform->getField('message');
$attachments = $messageField->getWidget()->getAttachments();

//Process post...depends on $ticket object above.
if($_POST && is_object($ticket) && $ticket->getId()):
    $errors=array();
    switch(strtolower($_POST['a'])){
    case 'edit':
        if(!$ticket->checkUserAccess($thisclient) //double check perm again!
                || $thisclient->getId() != $ticket->getUserId())
            $errors['err']=__('Access Denied. Possibly invalid ticket ID');
        elseif (!$cfg || !$cfg->allowClientUpdates())
            $errors['err']=__('Access Denied. Client updates are currently disabled');
        else {
            $forms=DynamicFormEntry::forTicket($ticket->getId());
            foreach ($forms as $form) {
                $form->setSource($_POST);
                if (!$form->isValid())
                    $errors = array_merge($errors, $form->errors());
            }
        }
        if (!$errors) {
            foreach ($forms as $f) $f->save();
            $_REQUEST['a'] = null; //Clear edit action - going back to view.
            $ticket->logNote(__('Ticket details updated'), sprintf(
                __('Ticket details were updated by client %s &lt;%s&gt;'),
                $thisclient->getName(), $thisclient->getEmail()));
        }
        break;
    case 'reply':
        if(!$ticket->checkUserAccess($thisclient)) //double check perm again!
            $errors['err']=__('Access Denied. Possibly invalid ticket ID');

        if(!$_POST['message'])

            $errors['message']=__('Message required');

        if(!$errors) {
            //Everything checked out...do the magic.
            $vars = array(
                    'userId' => $thisclient->getId(),
                    'poster' => (string) $thisclient->getName(),
                    'message' => $_POST['message']);
            $vars['cannedattachments'] = $attachments->getClean();
            if (isset($_POST['draft_id']))
                $vars['draft_id'] = $_POST['draft_id'];

            if(($msgid=$ticket->postMessage($vars, 'Web'))) {
                $msg=__('Message Posted Successfully');
                // Cleanup drafts for the ticket. If not closed, only clean
                // for this staff. Else clean all drafts for the ticket.
                Draft::deleteForNamespace('ticket.client.' . $ticket->getId());
                // Drop attachments
                $attachments->reset();
                $attachments->getForm()->setSource(array());
            } else {
                $errors['err']=__('Unable to post the message. Try again');
            }

        } elseif(!$errors['err']) {
            $errors['err']=__('Error(s) occurred. Please try again');
        }
        break;
    default:
        $errors['err']=__('Unknown action');
    }
    $ticket->reload();
endif;
$nav->setActiveNav('tickets');

$inc='alltickets.inc.php';

include(CLIENTINC_DIR.'header.inc.php');
include(CLIENTINC_DIR.$inc);
if ($tform instanceof DynamicFormEntry)
    $tform = $tform->getForm();
print $tform->getMedia();
include(CLIENTINC_DIR.'footer.inc.php');
?>
