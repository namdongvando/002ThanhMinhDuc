<?php

namespace Model;

class ComonModal
{


    static function ThongBao(
        $idModal,
        $title,
        $modal_body,
        $modal_footer = null,
        $z_index = 3000
    ) {

        $btnThoat = Btn::CloseModal("Đóng");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}" style="z-index:{$z_index}" aria-hidden="false">
    <div class="modal-dialog modal-thongbao"  >
        <div class="modal-content" >
            <div class="modal-header bg-green4">
                <h4 class="modal-title">{$title}</h4>
            </div>
            <div class="modal-body ">
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }
    static function ThongBaoBody(
        $idModal,
        $title,
        $modal_body,
        $modal_footer = null,
        $z_index = 3000
    ) {

        $btnThoat = Btn::CloseModal("Đóng");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}" style="z-index:{$z_index}" aria-hidden="false">
    <div class="modal-dialog "  >
        <div class="modal-content" >
            <div class="modal-body ">
                  <div class="text-center" >
                    <i style="    border: 1px solid green;
    background-color: green;
    color: #fff;
    padding: 5px;
    border-radius: 10px;
    font-size: 39px;
    height: 60px;
    width: 60px;
    line-height: 50px;" class="fa fa-2x fa-file-excel-o" aria-hidden="true"></i>
                  </div>
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }
    static function ModalNoHeader_1(
        $idModal
    ) {
        return <<<HTML
<div class="modal fade" id="{$idModal}" style="z-index:2000" aria-hidden="false">
    <div class="modal-dialog" >
        <div class="modal-content" >
            <div class="modal-body text-center">
            <i class="fa fa-spinner" aria-hidden="true"></i>
            </div> 
        </div>
    </div>
</div>
HTML;

    }
    static function ModalNoHeader(
        $idModal,
        $title,
        $modal_body,
        $box_tools = null,
        $modal_footer = null,
    ) {
        return <<<HTML
<div class="modal fade" id="{$idModal}" style="z-index:2000" aria-hidden="false">
    <div class="modal-dialog" >
        <div class="modal-content" >
            <div class="modal-body text-center">
            {$modal_body}
            </div> 
        </div>
    </div>
</div>
HTML;

    }

    static function ModalFormOnly(
        $idModal,
        $title,
        $modal_body,
        $box_tools = null,
        $modal_footer = null,
    ) {

        $btnThoat = Btn::CloseModal("Thoát");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}" aria-hidden="false">
    <div class="modal-dialog" style="width: 60%;top:40px" >
        <div class="modal-content">
            <div class="modal-body no-padding" style="min-height:100px;max-height:80vh" >
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }
    static function ModalForm(
        $idModal,
        $title,
        $modal_body,
        $box_tools = null,
        $modal_footer = null,
    ) {

        $btnThoat = Btn::CloseModal("Thoát");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}" aria-hidden="false">
    <div class="modal-dialog" style="width: 60%;top:40px" >
        <div class="modal-content">
            <div class="modal-header d-flex bg-modal">
                <h4 class="modal-title">{$title}</h4>
                <div class="box-tools" >
                    {$box_tools}
                </div>
            </div>
            <div class="modal-body no-padding">
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }
    static function ModalFormFull(
        $idModal,
        $title,
        $modal_body,
        $box_tools = null,
        $modal_footer = null,
    ) {

        $btnThoat = Btn::CloseModal("Thoát");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}" aria-hidden="false">
    <div class="modal-dialog" style="width: 100%;top: 0px;margin: 0px !important" >
        <div class="modal-content" style="height: 100vh" >
            <div class="modal-header d-flex bg-modal">
                <h4 class="modal-title">{$title}</h4>
                <div class="box-tools" >
                    {$box_tools}
                </div>
            </div>
            <div class="modal-body no-padding"  >
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }
    static function ModalFormWidth(
        $idModal,
        $title,
        $modal_body,
        $box_tools = null,
        $modal_footer = null,
        $width = "80%"
    ) {

        $btnThoat = Btn::CloseModal("Thoát");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}" aria-hidden="false">
    <div class="modal-dialog" style="width: {$width}" >
        <div class="modal-content">
            <div class="modal-header d-flex bg-modal">
                <h4 class="modal-title">{$title}</h4>
                <div class="box-tools" >
                    {$box_tools}
                </div>
            </div>
            <div class="modal-body no-padding">
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }
    static function ModalFormImport(
        $idModal,
        $title,
        $modal_body,
        $width = "30%"
    ) {

        $btnThoat = Btn::CloseModalIcon();
        $btnOK = Btn::BtnButton([
            "class" => "Btn_Save_Import btn btn-primary",
            "value" => Icon::Download,
        ]);
        $box_tools = $btnOK;
        $box_tools .= $btnThoat;

        return <<<HTML
<div class="modal fade" id="{$idModal}" aria-hidden="false">
    <div class="modal-dialog" style="width: {$width}" >
        <div class="modal-content">
            <div class="modal-header d-flex bg-modal">
                <h4 class="modal-title">{$title}</h4>
                <div class="box-tools" >
                    {$box_tools}
                </div>
            </div>
            <div class="modal-body no-padding">
                {$modal_body}
            </div> 
        </div>
    </div>
</div>
HTML;

    }
    static function ModalFormExport(
        $idModal,
        $title,
        $modal_body,
        $linkExoport,
        $width = "30%"
    ) {

        $btnThoat = Btn::CloseModalIcon();
        $btnOK = Btn::Btn(Icon::Upload, [
            "class" => "Btn_Save_Export btn btn-primary",
            "href" => $linkExoport,
        ]);
        $box_tools = $btnOK;
        $box_tools .= $btnThoat;

        return <<<HTML
<div class="modal fade" id="{$idModal}" aria-hidden="false">
    <div class="modal-dialog" style="width: {$width}" >
        <div class="modal-content">
            <div class="modal-header d-flex bg-modal">
                <h4 class="modal-title">{$title}</h4>
                <div class="box-tools" >
                    {$box_tools}
                </div>
            </div>
            <div class="modal-body text-center">
                {$modal_body}
            </div> 
        </div>
    </div>
</div>
HTML;

    }
    static function Modal_Phieu(
        $idModal,
        $title,
        $modal_body,
        $box_tools = null,
        $modal_footer = null,
    ) {

        $btnThoat = Btn::CloseModal("Thoát");

        if ($modal_footer) {
            $modal_footer = <<<HTML
             <div class="modal-footer">
                {$modal_footer}  
                {$btnThoat}
            </div>
HTML;
        }

        return <<<HTML
<div class="modal fade" id="{$idModal}"  style="z-index:2000" aria-hidden="false">
    <div class="modal-dialog" style="width: 60%" >
        <div class="modal-content">
            <div class="modal-header d-flex bg-modal-phieu">
                <h4 class="modal-title">{$title}</h4>
                <div class="box-tools" style="top: 5px">
                    {$box_tools}
                </div>
            </div>
            <div class="modal-body no-padding">
                {$modal_body}
            </div> 
            {$modal_footer}   
        </div>
    </div>
</div>
HTML;

    }


}


?>