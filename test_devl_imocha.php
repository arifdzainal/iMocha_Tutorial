<script>
    function submit_form() {
        var userid = $("#userid").val();
        var urlpath = $("#urlpath").val();
        document.form1.action = "test_devl_imocha_step2.php";
        document.form1.submit();
    }
</script>


<!DOCTYPE html>
<html>
    <body>
        <title>iMocha Test</title>
        <form name="form1" id="form1" action="test_devl_imocha_step2.php" method="post" enctype="multipart/form-data" >
            <br />
            <table width="100%" border="0">
                <tr>
                    <td colspan="3" class="bottom_header">Upload Call Report</td>
                </tr>
                <tr>
                    <td width="150" class="">Choose File</td>
                    <td colspan="2" class=""><input name="file_candidate_list" id="file_candidate_list" type="file" /> 
                        <input name="button" type="submit" value="Next" class="other_btn" onclick="this.disabled = true;this.value = 'Sending, please wait...';this.form.submit();submit_form()" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>