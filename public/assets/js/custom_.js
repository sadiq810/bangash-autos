$('document').ready(function () {
    loader = $('.loaderContainer');
    $('body').find('#addressLi').text(officeAddress);
    $('body').find('#phoneLi').text(phone);
    $('body').find('#mailLi').html(`<a href="mailto:${contactEmail}">${contactEmail}</a>`);

    if (facebookPageUrl)
        $('#fbLink').show().find('a').attr('href', facebookPageUrl);

    if (twitterUrl)
        $("#twLink").show().find('a').attr('href', twitterUrl);

    if (pinterestUrl)
        $("#pTLink").show().find('a').attr('href', pinterestUrl);

    if (youtubeUrl)
        $("#yTLink").show().find('a').attr('href', youtubeUrl);

    $('body').find('#phoneDiv').text(phone);
});
