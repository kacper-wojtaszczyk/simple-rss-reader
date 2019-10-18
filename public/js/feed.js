$(document).ready(function () {
    renderHeadings();
});

function renderHeadings() {
    for (let i = 0; i < headings.length; i++) {

        renderSingleFeedHeading(headings[i]);
    }

    $('#feedsList li').on('click', function () {
        renderSingleFeedBody($(this).attr('data-id'));
    });
    renderSingleFeedBody(headings[0]['id']);
}

function renderSingleFeedHeading(heading) {
    $('#feedsList').append("<li data-id='" + heading['id'] + "'>" + heading['title'] + "</li>");

}

function renderSingleFeedBody(id) {
    showOverlay
    $.ajax(
        '/_ajax/single-feed',
        {
            data: {id: id},
            method: "POST",
            error: function (j, t, s) {
                alert("There was an error processing your request: " + s);
            },
            success: function (data) {
                $('#feedHolder').html(data);
                hideOverlay();
            },
            dataType: 'html'
        }
    )
}

function showOverlay() {
    let overlay = $('#overlay:hidden');
    overlay.fadeIn();

}

function hideOverlay() {
    let overlay = $('#overlay:visible');
    overlay.fadeOut();
}