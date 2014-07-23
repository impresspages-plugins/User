

$( document ).ready(function() {
    $(".ipsUserProfileForm").on('ipSubmitResponse', function (e, response) {
        if (response && response.status && response.status == 'ok') {
            window.location = window.location.href.split('#')[0];
            window.location.reload(true)
        }
    });
    $(".ipsUserPasswordUpdateForm").on('ipSubmitResponse', function (e, response) {
        if (response && response.status && response.status == 'ok') {
            window.location = window.location.href.split('#')[0];
            window.location.reload(true)
        }
    });
});

