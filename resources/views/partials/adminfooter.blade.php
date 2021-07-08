<admin-app-footer></admin-app-footer>
<!--<div id="systemStatusModal" role="dialog" aria-labelledby="systemStatusModal" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog  mw-750">
        <div class="modal-content">
            <div class="modal-header pb-0 px-4 border-0 pt-4">
                <h3  class="modal-title ">System Status</h3>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close "><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body border-0 pt-0 px-4 pb-4">
                <div class="design-panel border-gray mt-0 p-0">
                    <div class="px-5 pb-5 pt-4">
                        <?php
                        $Responses = Helper::homePageURL();
                        if (!$Responses) {
                            $Responses = array();
                        }
                        ?>
                        <table id="myTable" class="display table table-striped site-table mw-100 w-100 mb-0" width="100%" >
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>From</th>
                                    <th>Until</th>               
                                    <th>Span</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($Responses) {
                                    foreach ($Responses as $key => $value) {
                                        if ($value['Status'] == 'Down') {
                                            $class = "down_class bg-danger";
                                        } else {
                                            $class = "up_class bg-success";
                                        }
                                        ?><tr>
                                            <td class="text-white text-center <?php echo $class; ?>"><?php echo $value['Status']; ?></td>
                                            <td><?php echo date('m-d-Y', strtotime($value['Start'])); ?></td>
                                            <td><?php echo date('m-d-Y', strtotime($value['End'])); ?></td>
                                            <td><?php echo $value['Period']; ?></td>
                                        </tr>

                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
