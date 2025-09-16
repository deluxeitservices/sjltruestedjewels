  function toggleTab(e){
        var hrefVal = $(e).attr('href');
        $('.nav-tabs li').removeClass('active');
        $('.nav-tabs li[data-active="'+hrefVal+'"]').addClass('active');
    }