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
                            <button class="btn btn-primary btn-icon glyphicons search"><i></i> ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ประเภทคำตอบ</h4>
        </div>
        <div class="widget-body">
            <div class="separator bottom form-inline small">
                <span class="pull-right" style="margin-left: 10px;">
					<a class="btn btn-primary btn-icon glyphicons circle_plus"
                       onclick="return multipleDeleteNews('/brother/admin/index.php/FormSurveyGroup/MultiDelete','FormSurveyGroup-grid');"
                       href="<?php echo $this->createUrl('survey/createtypeanswer'); ?>"><i></i> เพิ่มประเภทคำตอบ</a>
                </span>
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<select class="selectpicker" data-style="btn-default btn-small"
                            onchange="$.updateGridView('FormSurveyGroup-grid', 'news_per_page', this.value)"
                            name="news_per_page" id="news_per_page" style="display: none;">
                        <option value="">ค่าเริ่มต้น (10)</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="200">200</option>
                    </select>
                </span>
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">
                <div style="margin-top: -1px;" id="FormSurveyGroup-grid" class="grid-view">
                    <table
                        class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable">
                        <thead>
                        <tr>
                            <th width="10%" class="checkbox-column"><input class="select-on-check-all" type="checkbox"
                                                                           value="1" name="chk_all" id="chk_all"></th>
                            <th width="5%">ที่</th>
                            <th width="60%">ประเภทคำตอบ</th>
                            <th width="20%" class="button-column text-center">จัดการ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="even selectable">
                            <td class="checkbox-column"><input class="select-on-check" value="16" id="chk_1"
                                                               type="checkbox" name="chk[]"></td>
                            <td>1</td>
                            <td>ทดสอบ</td>
                            <td class="center"><a class="btn-action glyphicons eye_open btn-info"
                                                  title="ดูรายละเอียด"
                                                  href="#"><i></i></a>
                                <a class="btn-action glyphicons pencil btn-success" title="แก้ไข"
                                   href="#"><i></i></a> <a
                                    class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ"
                                    href="#"><i></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="keys" style="display:none" title="/brother/admin/index.php/FormSurveyGroup/index"><span>17</span><span>16</span><span>14</span>
                    </div>
                    <input type="hidden" name="FormSurveyGroup[news_per_page]" value=""></div>
            </div>
        </div>
    </div>

    <!-- Options -->
    <div class="separator top form-inline small">
        <!-- With selected actions -->
        <div class="buttons pull-left">
            <a class="btn btn-primary btn-icon glyphicons circle_minus"
               onclick="return multipleDeleteNews('/brother/admin/index.php/FormSurveyGroup/MultiDelete','FormSurveyGroup-grid');"
               href="#"><i></i> ลบข้อมูลทั้งหมด</a></div>
        <!-- // With selected actions END -->
        <div class="clearfix"></div>
    </div>
    <!-- // Options END -->

</div>