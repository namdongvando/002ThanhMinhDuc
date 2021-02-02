const TabVND = function(postSetWidth, nav_height) {

    var self = this;
    const $MainTabs = $("#MainTabs");
    /**
     * lấy thông tin khi có thay đổi
     * @param {type} parameter
     */
    window.onstorage = function() {
//        self.ShowTabonstorage();
    };

    /**
     * lấy tap trong location stoger
     * @param {type} parameter
     */

    this.ShowTabonstorageInit = function() {
        this.ShowTabonstorage();
        var target = "dc527633991ab7fd53d6299836a8042b93a17f73";
        var targetid = $("#" + target);
        this.openTag(targetid, target);

    }
    this.ShowTabonstorage = function() {
        var listTabs = self.getTabs();
        for (var item in listTabs) {
            self.updateTabHtml(listTabs[item].id, listTabs[item].title, listTabs[item].href);
        }
    }

    this.updateTabHtml = function(tabName, title, href) {
        /**
         * kiem tra tab đa có chua
         * @param {type} parameter
         */
        if (this.checkTabHtml(tabName) == false)
        {
            this.addTabhtml(tabName, title, href);
        } else {
            this.closeTab(tabName);
        }

    }

    this.addTab = function(tabName, title, href) {
        this.SaveTabs(tabName, title, href);
        this.updateTabHtml(tabName, title, href);
    }

    this.SaveTabs = function(tabName, title, href) {
        var dataTabs = self.getTabs();
        if (self.checkTab(tabName) == false) {
            dataTabs.push({"id": tabName, "title": title, "href": href});
            self.setTabs(dataTabs);
        }
    }

    /**
     *tra ve true neu tim thay
     * @param {type} parameter
     */

    this.checkTabHtml = function(tabName) {
        return  $('#MainTabs li[data-tabname="' + tabName + '"]').length > 0;
    }

    this.checkTab = function(tabName) {
        var listTab = self.getTabs();

        for (var item in listTab) {
            if (listTab[item].id == tabName)
                return true;
        }
        return false;
        return  $('#MainTabs li[data-tabname="' + tabName + '"]').length > 0;
    }
    this.resetTag = function(targetid, href, target) {
        if (targetid.length) {
            window.open(href, target);
            $("#vdnTabContent .tab-pane").removeClass("active");
            targetid.addClass("active");
        }
        return;
    }
    this.openTag = function(targetid, target) {
//        resetTag(targetid, href, target);

        $("#vdnTabContent .tab-pane").removeClass("active");
        targetid.addClass("active");
        $('#MainTabs li').removeClass("active");
        $('#MainTabs li[data-tabname="' + target + '"]').addClass("active");
    }
    this.closeTab = function(target) {
        var targetid = $("#" + target);
        $('#MainTabs li[data-tabname="' + target + '"]').remove();
        targetid.remove();
        self.removeTabs(target);
        return;
    }
    this.addTabhtml = function(tabName, title, href) {
        $("#MainTabs li").removeClass("active");
        var tabAction = '<span class="btn-close btn-action" data-tabname="' + tabName + '"  ><i class="fa fa-times" ></i></span><span class="linktotab btn-action  btn-reset" data-target="' + tabName + '" data-href="' + href + '"  ><i class="fa fa-refresh" ></i></span>';
        var tab = '<li role="presentation" data-tabname="' + tabName + '" class="presentation active"> <a href="#' + tabName + '" aria-controls="' + tabName + '" role="tab" data-toggle="tab">' + title + '</a>' + tabAction + '</li>';
        $("#MainTabs").append(tab);
        var tabcontent = '<div role="tabpanel" class="tab-pane active" id="' + tabName + '"><iframe src="' + href + '" class="tab-contentiframe" name="' + tabName + '" ></iframe></div>'
        $("#vdnTabContent").append(tabcontent);
        $(".tab-contentiframe").css('min-height', postSetWidth - nav_height - 5);
        self.Init();
        return;
    }

    this.Init = function() {

        $(".btn-close.btn-action").click(function() {
            var target = $(this).data("tabname");
            self.closeTab(target);
        });

        $(".btn-action.btn-reset").click(function() {
            var target = $(this).data("target");
            var href = $(this).data("href");
            var targetid = $("#" + target);
            self.resetTag(targetid, href, target);
        });
        $(".linktotab").click(function() {
            var $this = $(this);
            var target = $(this).data("target");
            var href = $(this).data("href");
            /**
             * Them moi tabs
             * @param {type} parameter
             */

            if (!self.checkTabHtml(target))
            {
                self.addTab(target, $(this).text(), href);
                var targetid = $("#" + target);
                self.resetTag(targetid, href, target);
            } else {
                var targetid = $("#" + target);
                self.openTag(targetid, target);
                self.resetTag(targetid, href, target);
            }
        });

    }
    this.removeTabs = function(id) {
        var index = this.seachTabs(id);
        var dataTabs = this.getTabs();
        if (index >= 0) {
            dataTabs.splice(index, 1);
            self.setTabs(dataTabs);
            return  true;
        }
        return  false;

    }
    this.seachTabs = function(id) {
        var listtabs = this.getTabs();
        for (var item in listtabs) {
            if (listtabs[item].id == id) {
                return item;
            }
        }
        return -1;
    }
    this.resetTabs = function() {
        this.setTabs([]);
    }
    this.setTabs = function(data) {

        window.localStorage.setItem("TabsHCdc", JSON.stringify(data));
    }
    this.getTabs = function() {
        if (window.localStorage.getItem("TabsHCdc"))
            return JSON.parse(window.localStorage.getItem("TabsHCdc"));
        return [];
    }
    this.Init();
    this.ShowTabonstorageInit();
}


