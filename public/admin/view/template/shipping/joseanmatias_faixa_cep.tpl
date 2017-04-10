<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-faixa_cep" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-faixa_cep" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $entry_status; ?></label>
                        <div class="col-md-9">
                            <select name="joseanmatias_faixa_cep_status" class="form-control">
                                <?php if ($joseanmatias_faixa_cep_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $entry_sort_order; ?></label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></div>
                                <input type="text" name="joseanmatias_faixa_cep_sort_order" value="<?php echo $joseanmatias_faixa_cep_sort_order; ?>" size="1" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <h3><?php echo $text_interval; ?></h3>
                    <div class="alert alert-info" role="alert"><?php echo $text_interval_info; ?></div>
                    <?php if ($error_faixa_cep_interval) { ?>
                        <p class="required"><?php echo $error_faixa_cep_interval; ?></p>
                    <?php } ?>


                    <table id="joseanmatias_faixa_cep" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="" class="text-left"><?php echo $entry_title; ?></th>
                                <th width="15%" class="text-left"><?php echo $entry_total; ?></th>
                                <th width="15%" class="text-left"><?php echo $entry_cep; ?></th>
                                <th width="15%" class="text-left"><?php echo $entry_cost; ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $row = 1; ?>
                            <?php foreach ($joseanmatias_faixa_cep_interval as $interval) { ?>
                                <tr id="joseanmatias_faixa_cep-row<?php echo $interval['key']; ?>">
                                    <td><?php echo $row; ?></td>
                                    <td class="text-left"><div class="input-group"><div class="input-group-addon"><i class="fa fa-text-width"></i></div><input type="text" name="joseanmatias_faixa_cep_interval[<?php echo $interval['key']; ?>][title]" value="<?php echo $interval['title']; ?>" size="50" class="form-control"></div></td>
                                    <td class="text-left"><div class="input-group"><div class="input-group-addon"><i class="fa"><?php echo $currency_simbol; ?></i></div><input type="text" name="joseanmatias_faixa_cep_interval[<?php echo $interval['key']; ?>][order_total]" size="8" value="<?php echo $interval['order_total']; ?>" class="form-control"></div></td>
                                    <td class="text-left"><input type="text" name="joseanmatias_faixa_cep_interval[<?php echo $interval['key']; ?>][cep]" value="<?php echo $interval['cep']; ?>" class="form-control"></td>
                                    <td class="text-right"><div class="input-group"><div class="input-group-addon"><i class="fa"><?php echo $currency_simbol; ?></i></div><input type="text" name="joseanmatias_faixa_cep_interval[<?php echo $interval['key']; ?>][cost]" value="<?php echo $interval['cost']; ?>" size="8" class="form-control"></div></td>
                                    <td class="text-left"><a onclick="$('#faixa_cep-row<?php echo $interval['key']; ?>').remove();" class="btn btn-danger"><?php echo $button_remove; ?></a></td>
                                </tr>
                                <?php $row++; ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td class="text-left"><a onclick="addCEP();" class="btn btn-success"><?php echo $button_add ?></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    function addCEP() {
        var token = Math.random().toString(36).substr(2);

        html = '  <tr id="joseanmatias_faixa_cep-row' + token + '">';
        html += '    <td>' + ($('tbody tr').length + 1) + '</td>';
        html += '    <td class="text-left"><div class="input-group"><div class="input-group-addon"><i class="fa fa-text-width"></i></div><input type="text" name="joseanmatias_faixa_cep_interval[' + token + '][title]" value="" size="50" class="form-control"></div></td>';
        html += '    <td class="text-left"><div class="input-group"><div class="input-group-addon"><i class="fa"><?php echo $currency_simbol; ?></i></div><input type="text" name="joseanmatias_faixa_cep_interval[' + token + '][order_total]" value="" size="8" class="form-control"></div></td>';
        html += '    <td class="text-left"><input type="text" name="joseanmatias_faixa_cep_interval[' + token + '][cep]" value="" class="form-control"></td>';
        html += '    <td class="text-right"><div class="input-group"><div class="input-group-addon"><i class="fa"><?php echo $currency_simbol; ?></i></div><input type="text" name="joseanmatias_faixa_cep_interval[' + token + '][cost]" value="" size="8" class="form-control"></div></td>';
        html += '    <td><a onclick="$(\'#joseanmatias_faixa_cep-row' + token + '\').remove();" class="btn btn-danger"><?php echo $button_remove; ?></a></td>';
        html += '  </tr>';

        $('#joseanmatias_faixa_cep tbody').append(html);

        row++;
    }
    //--></script>
<?php echo $footer; ?>