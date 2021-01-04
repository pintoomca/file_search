<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Company File Search</h1>
			</div>
            <div class="container">
                <form action="<?php echo base_url('search'); ?>" method="post">
                    <label for="fname">Folder</label>
                    <select name="folder">
                        <option value="C:/Users/P.Gautam/countapp">C:/Users/P.Gautam/countapp</option>
                        <option value="D:/xampp/htdocs/playg">D:/xampp/htdocs/</option>
                        <option value="E:/xampp/">E:\</option>
                        <option value="W:/26_11_2020/Pintoo_sample">W:/26_11_2020/Pintoo_sample</option>

                    </select>

                    <label for="country">Search Text</label>
                    <input type="text" id="searchContent" name="searchContent" placeholder="Enter the text">
                    <input type="submit" value="Search">
                </form>
            </div>
        </div>

        <?php
        if(!empty($list)) {
            ?>
            <form name="myform" action="<?php echo base_url('download_zip'); ?>" method="post">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><input type="button" onclick='selectAll()' value="Select All"/></th>
                        <th scope="col"><input type="button" onclick='UnSelectAll()' value="Unselect All"/></th>
                        <th scope="col"><input type="submit" name="export" value="Export"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($list as $listname) { ?>
                        <tr>
                            <td scope="row"><input type="checkbox" name="file[]" value="<?php echo $listname; ?>"></td>
                            <td><?php echo $listname; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </form>
        <?php  } ?>

    </div><!-- .row -->
</div><!-- .container -->
