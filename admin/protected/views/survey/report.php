<script>
    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", {role: "style"}],
            ["Copper", 8.94, "#b87333"],
            ["Silver", 10.49, "silver"],
            ["Gold", 19.30, "gold"],
            ["Platinum", 21.45, "color: #e5e4e2"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2]);

        var options = {
            title: "Density of Precious Metals, in g/cm^3",
            width: 600,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: {position: "none"},
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>
<div class="innerLR">
    <div class="widget" data-toggle="collapse-widget" data-collapse-closed="false">
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหา</h4>
        </div>
        <div class="widget-body in collapse" style="height: auto;">
            <div class="search-form">
                <div class="wide form">
                    <form id="SearchFormAjax" action="/brother/admin/index.php/formSurveyGroup/index" method="get">
                        <div class="row"><label>แบบสอบถาม</label>
                            <select>
                                <option>test</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-inline">
                                <label for="from">ตั้งแต่วันที่</label>
                                <input type="text" id="from" name="from">
                                <label for="to">ถึงวันที่</label>
                                <input type="text" id="to" name="to">

                                <div class="separator"></div>
                            </div>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary btn-icon glyphicons search"><i></i> ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>รายงาน</h4>
        </div>
        <div class="widget-body">
            <div class="col-md-6">
                <div id="columnchart_values"></div>
            </div>
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable">
                    <thead>
                    <tr>
                        <th rowspan="2">หัวข้อ</th>
                        <th>อบรมการใช้โปรแกรม Option wizard</th>
                    </tr>
                    <tr>
                        <th>คุณทำดี ได้ดี</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>ความรอบรู้ในเนื้อหาวิชา</td>
                        <td>80.23%</td>
                    </tr>
                    <tr>
                        <td>ความสามารถในการถ่ายทอดความรู้ให้ผู้ฟังเข้าใจ</td>
                        <td>79.45%</td>
                    </tr>
                    <tr>
                        <td>การใช้ภาษาและถ้อยคำให้เหมาะสมชัดเจน</td>
                        <td>56.78%</td>
                    </tr>
                    <tr>
                        <td>การถ่ายทอดเนื้อหาวิชาให้เป็นที่น่าสนใจ</td>
                        <td>78.76%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>