@extends('templates.main')

@push('plugins')
    <meta http-equiv="refresh" content="6; URL={{url('/')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endpush

@section('content')
    <p>&nbsp;</p>
    <p align="center">&nbsp;</p>
    <center>
        <div id="container" align="center">   
            <table width="100%"  border="0" align="center">
                <tr>
                    <td>
                        <table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
                            <tr>
                                <td width="100%">
                                    <h1 align="center">Ops... Parece que sua sessão ficou inativa por muito tempo.</h1>
                                    <h1 align="center">Você será direcionado automaticamente para a página inicial em <span id='secs'>5</span> segundos.</h1>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <p>&nbsp;</p>
        </div>
    </center>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
@endsection

@push('functions')
    <script language="javascript" type="text/javascript">
        var i = setInterval(function(){ 
            sec = $("#secs").html();
            if (sec <= 1){
                clearInterval(i);
            }
            $("#secs").html(sec-1);
        }, 1000);
    </script>
@endpush