    <div class="col-sm-12 no-padding">
        <div class="col-sm-10 no-padding">
            <a href="{{url('/debtor')}}/{{$debtor->Cd_Devedor or $debtorId}}" class="btn btn-info btn-xs col-sm-4">
                Contratos
            </a>
            <a href="{{url('/history')}}/{{$debtor->Cd_Devedor or $debtorId}}" class="btn btn-info btn-xs col-sm-4">
                Ocorrências
            </a>
            <a href="{{url('/agreement/show')}}/{{$debtor->Cd_Devedor or $debtorId}}" class="btn btn-info btn-xs col-sm-4">
                Acordos
            </a>
        </div>
        <div class="col-sm-2 no-padding"  style="height: 30px;">
            <a href="#" class="btn btn-info btn-xs col-sm-12" id="contacts-save" data-toggle="tooltip" title="Gravar contatos"  style="height: 30px;">
                <i class="ace-icon fa fa-save bigger-140 icon-only"></i>
            </a>
        </div>

        <form method="POST" action="{{url('/debtor/contacts/update')}}" name="contact-update" id="contact-update">
            {!! csrf_field() !!}
            <input type="hidden" name="contact-cdDevedor" value="{{$debtorId or 0}}">
            <input type="hidden" id="telephone-json" name="telephone-json" value="">
            <input type="hidden" id="email-json" name="email-json" value="">
        </form>
    
    </div>

    @push('functions')
        <script>    
            $('#contacts-save').on('click', function(e){
                var telephones = [];
                var emails = [];

                $('.select-telephone-level.select-altered').each(function () {
                    telephones.push({
                                        number: $(this).attr('data-telephone'), 
                                        areaCode: $(this).attr('data-areacode'), 
                                        status: $(this).val(),
                                    });
                });

                $('.select-email-level.select-altered').each(function () {
                    emails.push({
                                    email: $(this).attr('data-email'), 
                                    status: $(this).val(),
                                });
                });

                if ( (telephones.length == 0) && (emails.length == 0) ) {
                    showMessage('Nenhuma alteração foi detectada.');
                }else{
                    saveContactsChanges(telephones, emails);
                }
            });
    
            function saveContactsChanges(telephones, emails){
                $('#telephone-json').val(JSON.stringify(telephones));
                $('#email-json').val(JSON.stringify(emails));
                $('#contact-update').submit();
            }
        </script>
    @endpush