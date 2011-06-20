function wpbiz() {
    var self = this;
    jQuery('#tabs h4').each(function(){
        jQuery(this).bind('click', self, self.click);
        var p = jQuery(jQuery(this).parent().get(0));
        if (self.getStatus(p)) {
            var img = jQuery("img", this).get(0);
            jQuery(img).css('display', 'block');
        }
    });
}

wpbiz.prototype.click = function(e)
{
    var p = jQuery(this).parent().get(0);
    var content = jQuery('.block_content', p).get(0);
    var display = jQuery(content).css('display');
    e.data.reset();
    if (display !== 'block') {
        jQuery(this).attr('class', 'active');
        var params = {height:"toggle", opacity:"toggle"};
        jQuery(content).animate(params, 'fast');
        var postdivrich = jQuery('.postdivrich', content).get(0);
        jQuery(postdivrich).attr("id", "postdivrich");
        var poststuff = jQuery('.poststuff', content).get(0);
        jQuery(poststuff).attr("id", "poststuff");
    }
}

wpbiz.prototype.reset = function()
{
    jQuery('#poststuff').attr("id", "");
    jQuery('#postdivrich').attr("id", "");
    var params = {height:"toggle", opacity:"toggle"};
    jQuery('.block_content:visible').animate(params, 'fast');
    jQuery('h4').attr('class', '');
}

wpbiz.prototype.getStatus = function(o)
{
    var flag = false;
    jQuery('input[type="checkbox"]', o).each(function(){
        if (jQuery(this).attr('checked') == true) {
            flag = true;
        }
    });
    jQuery('select', o).each(function(){
        if (this.value.length) {
            flag = true;
        }
    });
    jQuery('input[type="text"]', o).each(function(){
        if (this.value.length) {
            flag = true;
        }
    });
    jQuery('textarea', o).each(function(){
        if (jQuery(this).val().length) {
            flag = true;
        }
    });
    return flag;
}

