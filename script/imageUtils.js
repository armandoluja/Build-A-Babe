"use-strict";

/*
function normalizeImages(){
    
    $( "img" ).each(function( index ) {
        $(this).on('load', function(){
            
            
            var width = this.clientWidth;
            var height = this.clientHeight;
            console.log(width+" "+height+" "+this.src);

            if($(this).width() === $(this).height()){
                //perfect square
                console.log("a");
                return true;//go to next
            }

            if($(this).width() < $(this).height()){
                var widthPercent = width/height;
                $(this).height($(this).width());
                $(this).width($(this).width()*widthPercent);
                $(this).wrap("<div style='text-align: center;'></div>");
                console.log("b");
                return true;//go to next
            }
            
            $(this).wrap("<div style='height:"+width+";'></div>");
            
            console.log("c");
            
       });
    });
}


$( window ).resize(function() {
    normalizeImages();
});
*/