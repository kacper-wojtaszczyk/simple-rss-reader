$(document).ready(function () {
    emailCheck();
});
let delayTimer;

function emailCheck() {

    validateEmail($('.emailToValidate'));
    $('.emailToValidate').on('input', function () {
        validateEmail($(this));
    })
}

function validateEmail($this) {
    $this.parent().removeClass('error');
    clearTimeout(delayTimer);
    let email = $this.val();
    delayTimer = setTimeout(function () {
        $.ajax('/_ajax/validate-email',
            {
                data: {email: email},
                method: "POST",
                error: function () {
                    $('.emailToValidate').parent().addClass('error');
                }
            }
        );
    }, 500);
}