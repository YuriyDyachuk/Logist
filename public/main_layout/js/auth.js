$auth_btn_step1     = $('.login .btn_step1');
$auth_btn_step2     = $('.login .btn_step2');
$auth_email         = $('.login #email');
$auth_password      = $('.login #password');
$auth_step1         = $('.step1');
$auth_step2         = $('.step2');
$errors             = $('.has-error');
$help_block         = $('.help-block');
$login_form         = $('.login .login-form')


var step = 1;
var csrf = $('meta[name="csrf-token"]').attr('content');
if($errors.length > 0)
    step = 2;

Auth = {
    checkEmail: function() {

        data = {_token: csrf, email:$auth_email.val()};

        $.post('/check/email', data, function(data, status){
            $errors.removeClass('has-error');
            $help_block.hide();

            if(data.result == 'success'){
                $auth_step1.hide();
                $auth_step2.show();
                step = 2;
            } else {
                appAlert('', data.msg, 'warning');
                $auth_step2.hide();
                $auth_step1.show();
                step = 1;
            }
        }).fail(function() {
            appAlert('', 'error', 'warning');
        });

    }
}


$login_form.submit(function( event ) {
    console.log(step);
    if(step == 1) {
        event.preventDefault();
        Auth.checkEmail();
    }
});


$auth_btn_step1.click(function () {
    Auth.checkEmail();
});