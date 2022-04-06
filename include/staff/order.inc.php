<?php
if(!defined('OSTSCPINC') || !$thisstaff) die('Access Denied');

$qs = array();

$select = "Select (
                    SELECT fev.value
                    FROM desenvolvimento.chamados_form_entry_values fev join desenvolvimento.chamados_form_entry fe
                            on fev.entry_id = fe.id
                    where fev.field_id = 36
                      and fe.form_id = 2
                      and fe.object_id = t.ticket_id) Ordem, 
                    ticket_id, number, 
                    (
                    SELECT fev.value
                    FROM desenvolvimento.chamados_form_entry_values fev join desenvolvimento.chamados_form_entry fe
                            on fev.entry_id = fe.id
                    where fev.field_id = 20
                      and fe.form_id = 2
                      and fe.object_id = t.ticket_id
                    ) Subject, 
                    u.name De, concat(s.firstname, ' ', s.lastname) Agente
            from chamados_ticket t join chamados_user u
                    on t.user_id = u.id
                    left join chamados_staff s
                    on t.staff_id = s.staff_id
            where t.status_id not in (3, 8,9,10,11)
              and t.dept_id = 1
            Order by 1 desc";

$query="$select";
//echo $query;
$qhash = md5($query);
$_SESSION['users_qs_'.$qhash] = $query;

?>
<h2><?php echo __('Priorização de chamados'); ?></h2>

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
 <table class="list table table-hover table-striped" border="0" cellspacing="1" cellpadding="0" width="100%" id="tblOrder">
    <thead>
        <tr>
            <th><?php echo __('Ordem'); ?></th>
            <th><?php echo __('Número'); ?></th>
            <th><?php echo __('Assunto'); ?></th>
            <th><?php echo __('De'); ?></th>
            <th><?php echo __('Agente'); ?></th>
        </tr>
    </thead>
    <tbody style="cursor:move">
    <?php
        if($res && db_num_rows($res)):
            $ids=($errors && is_array($_POST['ids']))?$_POST['ids']:null;
            while ($row = db_fetch_array($res)) {
     ?>
               <tr>
                <td><?php echo $row['Ordem']; ?></td>
                <td><?php echo $row['number']; ?></td>
                <td><?php echo $row['Subject']; ?></td>
                <td><?php echo $row['De']; ?></td>
                <td><?php echo $row['Agente']; ?></td>
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

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script
  src="http://code.jquery.com/jquery-2.1.4.min.js"
  integrity="sha256-8WqyJLuWKRBVhxXIL1jBDD7SDxU936oZkCnxQbWwJVw="
  crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('tbody').sortable({
            update: function( event, ui ) {
                $(this).children().each(function(index) {
                        $(this).find('td').first().html(index + 1);
                });
                //getTable();
            }
        });

    </script>  

