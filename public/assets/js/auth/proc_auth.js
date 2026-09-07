function proc_login() {
    var pUser_Name = $("#user_name").val();
    var pUser_Pass = $("#user_pass").val();

    if (pUser_Name == "") {
        $("#user_name").focus();
        normal_alert("Warning", "Please Enter User Name !!", "warning");
    } else if (pUser_Pass == "") {
        $("#user_pass").focus();
        normal_alert("Warning", "Please Enter User Password !!", "warning");
    } else {
        $.ajax({
            url: baseurl + "/User/Login",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                pUser_Name: pUser_Name,
                pUser_Pass: pUser_Pass,
            },
            beforeSend: function () {
                $("#global-loader").fadeIn();
            },
            success: function (response) {
                if (response.status === "success") {
                   window.location.href = baseurl + response.redirect;
                } else {
                    normal_alert("Error", response.message || "Something went wrong!", "error");
                }
            },
            error: function (xhr) {
                let msg = xhr.responseJSON?.message || "Something Went Wrong";
                normal_alert("Error", msg, "error");
            },
            complete: function () {
                $("#global-loader").fadeOut("slow");
            },
        });
    }
}


function proc_signup() {
    var pFull_Name = $("#full_name").val();
    var pUser_Name = $("#user_name").val();
    var pUser_Pass = $("#user_pass").val();
    var pCounter_Id = $("#counter_id").val();

    if (pFull_Name == "") {
        $("#full_name").focus();
        Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please Enter Full Name !!' });
    } else if (pUser_Name == "") {
        $("#user_name").focus();
        Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please Enter User Name !!' });
    } else if (pUser_Pass == "") {
        $("#user_pass").focus();
        Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please Enter User Password !!' });
    }else if (pCounter_Id == "") {
        $("#counter_id").focus();
        Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please Select a Counter !!' });
    } 
    else {
        $.ajax({
            url: baseurl + "/User/Signup",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                pFull_Name: pFull_Name,
                pUser_Name: pUser_Name,
                pUser_Pass: pUser_Pass,
               pCounter_Id: pCounter_Id,
            },
            beforeSend: function () {
                $("#global-loader").fadeIn();
            },
            success: function (response) {
                $("#global-loader").fadeOut("slow");
                if (response.status === "success") {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Success', 
                        text: response.message 
                    }).then(function() {
                        window.location.href = baseurl;
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Something went wrong!' });
                }
            },
            error: function (xhr) {
                $("#global-loader").fadeOut("slow");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = Object.values(errors).flat().join('\n');
                    Swal.fire({ icon: 'error', title: 'Validation Error', text: errorMsg });
                } else {
                    let errorMessage = xhr.responseJSON?.message || "Unknown error";
                    Swal.fire({ icon: 'error', title: 'Error', text: errorMessage });
                }
            },
            complete: function () {
                $("#global-loader").fadeOut("slow");
            },
        });
    }
}