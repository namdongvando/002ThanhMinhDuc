var saveTabMenu = function (dataconfig) {
    var Cname = "saveTabMenu";
    this.saveData = function () {
        var d = new Date();
        d.setTime(d.getTime() + (10 * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = Cname + "=" + dataconfig + ";" + expires + "";
    }
    this.getData = function (macdinh) {
        var cname = Cname;
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return macdinh;
    }

    this.dataToJson = function () {
        return JSON.parse(this.getData({ "active": "infor" }));
    }

}

var TabActive = function (dataConfig) {
    var $self = this;
    $self.Id = null;
    $self.Role = dataConfig.data("role");
    $("#" + $self.Role + ".TabActive .nav-tabs li a").click(function () {
        $self.Id = $(this).data("active");
        var dataTabs = {
            "Role": $self.Role,
            "Id": $self.Id,
        }
        $self.SaveTabs($self.Role, JSON.stringify(dataTabs));
    });
    this.SaveTabs = function (name, value) {
        window.localStorage.setItem(name, value);
    }
    this.getTabData = function () {
        var a = window.localStorage.getItem($self.Role);
        if (a)
            return JSON.parse(a);
        return null;
    }
    /**
     * chay mac dinh
     * @param {type} parameter
     */

    var DataTab = this.getTabData();
    if (DataTab) {
        $(".TabActive[data-role='" + $self.Role + "'] .nav-tabs li").removeClass("active");
        $(".TabActive[data-role='" + $self.Role + "'] .nav-tabs li[for='" + DataTab.Id + "']").addClass("active");
        $(".tab-pane").removeClass("active");
        $(".tab-pane#" + DataTab.Id).addClass("active");
    }
}

const ConfirnXoa = function () {
    this.Confirm = function (mes) {
        return confirm(mes);
    }

}
const websitetoggleKey = "websitetoggleKey";
const websiteToggle = function () {
    var websiteToggleLoal = window.localStorage.getItem(websitetoggleKey);
    if (websiteToggleLoal) {
        return JSON.parse(websiteToggleLoal);
    }
    return {
        TimKiemtoggle: true
    }
}

$(function () {
    $(".CheckAllCol").change(function () {
        var self = $(this);
        var role = $(this).attr("role");
        var isCheck = self.prop("checked");
        $("input[rolecol='" + role + "']").prop("checked", isCheck);

    });
    $(".CheckAllRows").change(function () {
        var self = $(this);
        var role = $(this).attr("role");
        var isCheck = self.prop("checked");
        $("input[rolerow='" + role + "']").prop("checked", isCheck);

    });
    $(".btn-toggle").each(function () {
        try {
            var data = $(this).data();
            var dataToggle = websiteToggle();
            console.log(dataToggle);
            if (dataToggle.TimKiemtoggle == true) {
                $(data.target).show();
            } else {
                $(data.target).hide();
            }

            $(this).click(function () {
                if (dataToggle.TimKiemtoggle == false) {
                    $(data.target).show(500);
                    dataToggle.TimKiemtoggle = true;
                } else {
                    $(data.target).hide(500);
                    dataToggle.TimKiemtoggle = false;
                }
                window.localStorage.setItem(websitetoggleKey, JSON.stringify(dataToggle));
            });
        } catch (e) {
            console.log(e);
        }
    });
    $("select.AjaxHTML").each(function () {
        var dataHTML = $(this).data();
        var self = $(this);
        var object = dataHTML.object;
        //        console.log();
        self.change(function () {
            if (dataHTML.values == true) {
                var url = dataHTML.url;
                url = url + self.val();
            }
            $.ajax({ url: url }).done(function (res) {
                //                console.log(res);
                $(object).html(res);
                $(object).select2();
            });
        });
    });
    setInterval(function () {
        $(".alert").hide();
    }, 3000);
    $(".xoa").click(function () {
        var $mes = $(this).data("confirm");
        var confirm = new ConfirnXoa();
        return confirm.Confirm($mes);
    });
    $(".confirm").click(function () {
        var $mes = $(this).data("confirm");
        var confirm = new ConfirnXoa();
        return confirm.Confirm($mes);
    });
    try {
        $.fn.dataTableExt.sErrMode = 'throw';
    } catch (err) {
        console.log(err);
    }

    $(".dataTableAjaxServer").each(function () {
        var dataTable = $(this).data();
        var btn = $(this).data("btn");
        try {
            $("#" + $(this).attr("id")).DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": dataTable.ajax,
                "language": {
                    "decimal": "",
                    "emptyTable": "Không có dữ liệu",
                    "info": "Hiển từ _START_ đến _END_ của _TOTAL_ Dòng",
                    "infoEmpty": "Hiển thị từ 0 Đến 0 Của 0 Dòng",
                    "infoFiltered": "(Tìm Từ _MAX_ dòng)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": "Hiển thị _MENU_ Dòng",
                    "loadingRecords": "đang tải...",
                    "processing": "đang tải...",
                    "search": "Tìm Kiếm:",
                    "zeroRecords": "Không tìm thấy kết quả",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "<i class='fa fa-chevron-right' ></i>",
                        "previous": "<i class='fa fa-chevron-left' ></i>"
                    },
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
                , initComplete: function () {

                    var i = 0;
                    var getColumns = 0;
                    if ($(this).data("column")) {
                        getColumns = $(this).data("column");
                    }
                    $("div.toolbardatatable").html($(btn).html());
                    this.api().columns().every(function () {
                        if (getColumns) {
                            if (getColumns.indexOf(i) >= 0) {
                                var column = this;
                                var select = $('<select style="max-width:200px;" ><option value="">-- tất cả --</option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                                    });
                                column.data().unique().sort().each(function (d, j) {
                                    select.append('<option value="' + d.toString().replace(/(<([^>]+)>)/ig, "") + '">' + d.toString().replace(/(<([^>]+)>)/ig, "") + '</option>');
                                });
                            }
                        }
                        i++;
                    });
                }
            });
        } catch (e) {
            console.log(e.message);
        }

    });
    $(".dataTableAjax").each(function () {
        var btn = $(this).data("btn");
        $("#" + $(this).attr("id")).DataTable({
            "start": 0,
            "processing": false,
            "serverSide": false,
            "language": {
                "decimal": "",
                "emptyTable": "Không có dữ liệu",
                "info": "Hiển từ _START_ đến _END_ của _TOTAL_ Dòng",
                "infoEmpty": "Hiển thị từ 0 Đến 0 Của 0 Dòng",
                "infoFiltered": "(Tìm Từ _MAX_ dòng)",
                "infoPostFix": "",
                "thousands": ".",
                "lengthMenu": "Hiển thị _MENU_ Dòng",
                "loadingRecords": "đang tải...",
                "processing": "đang xử lý...",
                "search": "Tìm Kiếm:",
                "zeroRecords": "Không tìm thấy kết quả",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "<i class='fa fa-chevron-right' ></i>",
                    "previous": "<i class='fa fa-chevron-left' ></i>"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
            , initComplete: function () {
                var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
                var nav_height = $('.nav.nav-tabs').outerHeight();
                var window_height = $(window).height();
                var postSetWidth = window_height - neg;
                TabVND(postSetWidth, nav_height);
                var i = 0;
                if ($(this).data("column")) {
                    var getColumns = $(this).data("column");
                }
                $("div.toolbardatatable").html($(btn).html());
                this.api().columns().every(function () {
                    if (getColumns) {
                        if (getColumns.indexOf(i) >= 0) {
                            var column = this;
                            var select = $('<select style="max-width:200px;" ><option value="">-- tất cả --</option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d.toString().replace(/(<([^>]+)>)/ig, "") + '">' + d.toString().replace(/(<([^>]+)>)/ig, "") + '</option>');
                            });
                        }
                    }
                    i++;
                });
                $(".AjaxGetUrl").change(function () {
                    var linkajax = $(this).data("link");
                    $.get(linkajax, function (res) {
                        alert("Cập nhật thành công.");
                    });
                })
            }
        });
    });
    $(".dataTableMaDinh").each(function () {

        $("#" + $(this).attr("id")).DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Hiển từ _START_ đến _END_ của _TOTAL_ hạng mục",
                "infoEmpty": "Hiển thị từ 0 Đến 0 Của 0 dòng",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Hiển Thị _MENU_ dòng",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "search": "Tìm Kiếm:",
                "zeroRecords": "Không tìm thấy kết quả",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "<i class='fa fa-chevron-right' ></i>",
                    "previous": "<i class='fa fa-chevron-left' ></i>"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });
    });
    try {
        $("#dataTable1").DataTable();
        $(".dataTable").each(function () {

            var language = {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Hiển từ _START_ đến _END_ của _TOTAL_ hạng mục",
                "infoEmpty": "Hiển thị từ 0 Đến 0 Của 0 dòng",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Hiển Thị _MENU_ dòng",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "search": "Tìm Kiếm:",
                "zeroRecords": "Không tìm thấy kết quả",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "<i class='fa fa-chevron-right' ></i>",
                    "previous": "<i class='fa fa-chevron-left' ></i>"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }

            var self = $(this);
            var Id = "#" + self.attr("id");
            var config = self.data();
            config.lengthChange = config.lengthchange;
            delete config.lengthchange;
            config.pageLength = config.pagelenght;
            delete config.pagelenght;
            config.lenghtMenu = config.lenghtmenu;
            delete config.lenghtmenu;
            config.language = language;
            //        console.log(config);
            $(Id).DataTable(config);
        });
        $('#dataTable2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    } catch (e) {
        console.log(e);
    }

    if (typeof select2 == "function") {
        $(".select2").select2({ width: 'resolve' });
    }
    try {
        $(".owl-carousel").each(function (index, el) {
            var config = $(this).data();
            config.smartSpeed = "300";
            if ($(this).hasClass('owl-style2')) {
                config.animateOut = "fadeOut";
                config.animateIn = "fadeIn";
            }
            $(this).owlCarousel(config);
        });
        $(".editor").each(function (index, el) {
            try {
                var sefl = $(this);
                var ideditor = sefl.attr("id");
                CKEDITOR.replace(ideditor);
            } catch (e) {
                console.log("|asas");
                console.log(e.message);
            }
        });
        $(".sortable").sortable({
            placeholder: "sort-highlight",
            handle: ".handle",
            forcePlaceholderSize: true,
            zIndex: 999999,
        });
        $(".pages.todo-list").sortable({
            placeholder: "sort-highlight",
            handle: ".handle",
            forcePlaceholderSize: true,
            zIndex: 999999,
            update: function (event, ui) {
                var config = $(this).data();
                var data = $(config.form).serializeArray();
                $.post(config.update, data, function (res) { });
            }
            , create: function (event, ui) {
                var binding = function (template, item) {

                    var reg = new RegExp("\\{(\\S+)\\}", "gi");
                    var result = template.match(reg);
                    if (result) {
                        for (var i = 0; i < result.length; i++) {
                            var len = result[i].length;
                            var b = result[i].substring(1, len - 1);
                            template = template.replace(result[i], eval(b));
                        }
                    }
                    return template;
                }
                var self = $(this);
                var config = $(this).data();
                var template = self.html();
                self.html("");
                $.get(config.items, function (res, st) {
                    for (var i in res.data) {
                        //                    console.log(res.data[i]);
                        var htmlItemm1 = binding(template, res.data[i]);
                        self.append(htmlItemm1);
                    }
                }, "json");
            }
        });
        $(".ckboxAll").change(function () {
            var self = $(this);
            var role = self.attr("role");
            var item = $(".ckboxitem[role=" + role + "]");
            if (self.prop("checked")) {
                item.prop("checked", true);
            } else {
                item.prop("checked", false);
            }
        });
    } catch (e) {

    }

    try {
        $("input.datecustom").each(function () {
            var self = $(this);
            var config = self.data("config");
            self.datepicker(config);
        });
        $("input.date").each(function () {
            var self = $(this);
            var config = {
                format: "dd-mm-yyyy",
                maxViewMode: 0,
                todayBtn: "linked",
                language: "vi",
                calendarWeeks: true,
                autoclose: true
            };
            self.datepicker(config).on("changeDate", function (e) {
                self.children("input").val(new Date(e.timeStamp));
            });
        });
    } catch (e) {
        console.log(e.message);
    }

    $(".saveCookie").click(function () {
        var config = JSON.stringify($(this).data());
        var saveTM = new saveTabMenu(config).saveData();
        //        saveTM.saveData();
    });
    $(".TabActive").each(function () {
        TabActive($(this));
    });
    $(".tabhistory").each(function () {

        var saveTM = new saveTabMenu().dataToJson();
        $(".tabhistory li[for]").each(function (e) {
            $(this).removeClass("active");
            var a = $(this).attr("for");
            if (a == saveTM.active) {
                $(this).addClass("active");
                $("#" + a).addClass("active");
            } else {
                $("#" + a).removeClass("active");
            }

        })

    });
    try {
        if (typeof wysihtml5 != 'undefined')
            $(".wysihtml5").wysihtml5();
    } catch (e) {
        console.log(e.message);
    }
    try {
        $('.datetimepicker').each(function () {
            var self = $(this);
            self.datetimepicker(self.data("config"));
        })

    } catch (e) {
        console.log(e.message);
    }
    try {
        // $("select").select2();
        $("select").select2({ width: 'resolve' });
    } catch (e) {
        console.log(e);
    }


    var $windown = $(window);
    var a = $windown.innerWidth();
    $windown.resize(function () {
        if (a != $windown.innerWidth())
            window.location.reload();
    });
    $('.ajaxAutoReload').each(function () {
        var data = $(this).data();
        var id = data.target;
        setInterval(function () {
            $.ajax({ url: data.urlcheck }).done((res) => {
                var coderefesh = window.localStorage.getItem(id);
                console.log(coderefesh);
                console.log(res.code);
                window.localStorage.setItem(id, res.code);
                if (coderefesh != res.code) {
                    $.ajax({ url: data.urldata }).done((res) => {
                        $(id).html(res);
                    });
                }
            });
        }, parseInt(data.timeload));
    });
});
function getCookie(cname, macdinh) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return macdinh;
}
function decodeUrl(str) {
    str = str.replace(/\%2F/gi, "/");
    str = str.replace(/\%3A/gi, ":");
    return str;
}

function BrowseServer(functionData, startupPath = "Images:/news/", thumbnaiId = "thumbnaiImg", isNews = false) {

    /**
     * khong náy cookie
     * @param {type} parameter
     */

    if (isNews == false) {
        startupPath = decodeUrl(getCookie("CKFinderStartupPath", startupPath));
    }

    var finder = new CKFinder();
    finder.startupPath = startupPath;
    finder.BasePath = "../";
    finder.language = "en";
    finder.type = "Images";
    finder.selectActionData = functionData;
    finder.selectActionFunction = function (fileUrl, data) {
        //        console.log('Chon');
        //        console.log(data["selectActionData"]);
        document.getElementById(data["selectActionData"]).value = fileUrl;
        document.getElementById(data["selectActionData"] + "Img").src = fileUrl;
    };
    finder.selectThumbnailActionFunction = function (fileUrl, data) {
        //        console.log("thumnail");
    };
    finder.popup();
}
function BrowseServer1() {
    try {
        var config = {};
        // Always use 100% width and height when nested using this middle page.
        config.width = config.height = '100%';
        config.language = "vi";
        var ckfinder = new CKFinder(config);
        ckfinder.replace('ckfinder');
    } catch (e) {
        console.log(e.message);
    }

}
$(function () {
    if ($("#ckfinder"))
        BrowseServer1();
});
// This is a sample function which is called when a file is selected in CKFinder.
function SetFileField(fileUrl, data) {

    document.getElementById(data["selectActionData"]).value = fileUrl;
}
