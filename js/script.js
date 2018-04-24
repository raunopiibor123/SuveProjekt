//Find current link in navbar and make it active
$(document).ready(function() {
    var url = this.location.pathname;
    var filename = url.substring(url.lastIndexOf('/')+1);
    $('a[href="' + filename + '"]').parent().addClass('active');    
});