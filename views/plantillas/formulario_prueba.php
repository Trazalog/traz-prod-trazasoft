<form role="form" id="formejemplo">
<div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username" />
    </div>

    <div class="form-group">
        <label>Email address</label>
        <input type="text" class="form-control" name="email" />
    </div>
    <button type="button" class="btn btn-primary" onclick="Validar()">Aceptar</button>
</form>
<script>
$(document).ready(function() {
    $('#formejemplo').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            }
        }
    });
});

function Validar()
{
 $('#formejemplo').bootstrapValidator('validate');
   estado= $('#formejemplo').data('bootstrapValidator').isValid();
   if (estado)
   {
   linkTo('<?php echo base_url(PRD) ?>general/Etapa/index');
   }
}
</script>