function AjaxPost(formName = null, fillID = null) {
    if (formName != null)
    {
        var formVals = $('#' + formName).serializeArray();
        var formData = new FormData();

        $.each(formVals, function (key, val){
            formData.append(val.name, val.value);
        });

        $.ajax({
            url: $("#" + formName).attr('action'),
            method: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (response){
                if (typeof(response.msg) != 'undefined' && response.error == 1)
                {
                    toastr['error'](response.msg, "İşlem başarısız", {
                        positionClass: 'toast-bottom-right',
                        closeButton: true,
                        progressBar: true,
                        preventDuplicates: false,
                        newestOnTop: false,
                        rtl: false
                    });
                    return false;
                }
                else
                {
                    if (typeof response.msg != "undefined" && response.msg != "")
                    {
                        var toast_type = 'success';

                        if (typeof response.type != "undefined" && response.type != "")
                            toast_type = response.type;

                        toastr[toast_type](response.msg, "İşlem başarılı", {
                            positionClass: 'toast-bottom-right',
                            closeButton: true,
                            progressBar: true,
                            preventDuplicates: false,
                            newestOnTop: false,
                            rtl: false
                        });
                    }

                    if (fillID != null)
                    {
                        $('#' + fillID).html(response.view);
                    }
                }
            }
        });
    }
    else
    {
        toastr['error']('Post edilecek form bulunamadı', "İşlem başarısız", {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            progressBar: true,
            preventDuplicates: false,
            newestOnTop: false,
            rtl: false
        });
        return false;
    }
}
