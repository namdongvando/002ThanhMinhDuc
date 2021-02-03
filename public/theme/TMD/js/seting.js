$(function () {
    $(window).scroll(function () {

        var html = $("html");
        var windowsScrollTop = html.scrollTop();
        var affix = $(".affix");
        var affixData = affix.data();

        //    console.log(affixData.top);
        //    console.log(windowsScrollTop);

        if (windowsScrollTop > affixData.top) {
            $(".affix").addClass(affixData.class);
            //      fixed-top
        } else {
            $(".affix").removeClass(affixData.class);

        }
    });
  
  
  $(".owl-custom").each(function(){
      var self = $(this);
      var owlData = $(this).data();
      console.log(owlData);
      self.owlCarousel(owlData);
       
  });
    
  
});
