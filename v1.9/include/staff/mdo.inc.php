<?php
if(!defined('OSTSCPINC') || !$thisstaff) die('Access Denied');

$qs = array();

$select = 'select s.username, s.ticket_actual, t.ticket_id, d.subject';

$from = 'from gestor_staff s left join gestor_ticket t '.
        '              on (s.ticket_actual = t.number) '.
		'			  left join gestor_ticket__cdata d '.
		'			  on (d.ticket_id = t.ticket_id) ';

$where='where s.username <> "super" and s.isactive = 1 ';

$order_by = 's.username';

$query="$select $from $where ORDER BY $order_by ";
//echo $query;
$qhash = md5($query);
$_SESSION['users_qs_'.$qhash] = $query;

?>
<h2><?php echo __('MDO Atual'); ?></h2>

<div class="pull-right">
    <div id="action-dropdown-more" class="action-dropdown anchor-right">
        <ul>
            <li><a class="users-action" href="#delete">
                <i class="icon-trash icon-fixed-width"></i>
                <?php echo __('Delete'); ?></a></li>
            <li><a href="#orgs/lookup/form" onclick="javascript:
$.dialog('ajax.php/orgs/lookup/form', 201);
return false;">
                <i class="icon-group icon-fixed-width"></i>
                <?php echo __('Add to Organization'); ?></a></li>
        </ul>
    </div>
</div>

<div class="clear"></div>
<?php
$showing = $search ? __('Search Results').': ' : '';
$res = db_query($query);
?>
<form id="users-list" action="users.php" method="POST" name="staff" >
 <?php csrf_token(); ?>
 <input type="hidden" name="do" value="mass_process" >
 <input type="hidden" id="action" name="a" value="" >
 <input type="hidden" id="selected-count" name="count" value="" >
 <input type="hidden" id="org_id" name="org_id" value="" >
 <table class="list" border="0" cellspacing="1" cellpadding="0" width="940">

    <thead>
        <tr>
            <th width="350"><?php echo __('Agente'); ?></th>
            <th width="350"><?php echo __('Ticket'); ?></th>
            <th width="350"><?php echo __('Subject'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($res && db_num_rows($res)):
            $ids=($errors && is_array($_POST['ids']))?$_POST['ids']:null;
            while ($row = db_fetch_array($res)) {
     ?>
               <tr>
                <td><?php echo $row['username']; ?></td>
                <td><a href="tickets.php?id=<?php echo $row['ticket_id']; ?>"><?php echo $row['ticket_actual']; ?></a></td>
                <td><?php echo $row['subject']; ?></td>
               </tr>
            <?php
            } //end of while.
        endif; ?>
    </tbody>
</table>
<?php
if($res && $num): //Show options..
    echo sprintf('<div>&nbsp;'.__('Page').': %s &nbsp; <a class="no-pjax"
            href="users.php?a=export&qh=%s">'.__('Export').'</a></div>',
            $pageNav->getPageLinks(),
            $qhash);
endif;
?>
</form>

<script type="text/javascript">
$(function() {
    $('input#basic-user-search').typeahead({
        source: function (typeahead, query) {
            $.ajax({
                url: "ajax.php/users/local?q="+query,
                dataType: 'json',
                success: function (data) {
                    typeahead.process(data);
                }
            });
        },
        onselect: function (obj) {
            window.location.href = 'users.php?id='+obj.id;
        },
        property: "/bin/true"
    });

    $(document).on('click', 'a.popup-dialog', function(e) {
        e.preventDefault();
        $.userLookup('ajax.php/' + $(this).attr('href').substr(1), function (user) {
            var url = window.location.href;
            if (user && user.id)
                url = 'users.php?id='+user.id;
            $.pjax({url: url, container: '#pjax-container'})
            return false;
         });

        return false;
    });
    var goBaby = function(action, confirmed) {
        var ids = [],
            $form = $('form#users-list');
        $(':checkbox.mass:checked', $form).each(function() {
            ids.push($(this).val());
        });
        if (ids.length) {
          var submit = function() {
            $form.find('#action').val(action);
            $.each(ids, function() { $form.append($('<input type="hidden" name="ids[]">').val(this)); });
            $form.find('#selected-count').val(ids.length);
            $form.submit();
          };
          if (!confirmed)
              $.confirm(__('You sure?')).then(submit);
          else
              submit();
        }
        else {
            $.sysAlert(__('Oops'),
                __('You need to select at least one item'));
        }
    };
    $(document).on('click', 'a.users-action', function(e) {
        e.preventDefault();
        goBaby($(this).attr('href').substr(1));
        return false;
    });
    $(document).on('dialog:close', function(e, json) {
        $form = $('form#users-list');
        try {
            var json = $.parseJSON(json),
                org_id = $form.find('#org_id');
            if (json.id) {
                org_id.val(json.id);
                goBaby('setorg', true);
            }
        }
        catch (e) { }
    });
});
</script>

