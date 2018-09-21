<div class="container">
	<div class="row">
		<div class="col-md-3">
			<p>count of products:</p>
		</div>
		<div class="col-md-2">
			<p id="count_products">
				<?php echo \tsr\Db::get_count_product() ?>
			</p>
		</div>
        <div class="col-md-2">
            <p id="current_count_products"></p>
        </div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="">
				<div class="form-group">
					<label for="add-product-input">Add products</label>
					<input class="form-control col-4" type="text" value="100" id="add-product-input">
				</div>
                <div class="form-group">
                    <label for="add-product-iteration">Count of one iteration</label>
                    <input class="form-control col-4" type="text" value="10" id="add-product-iteration">
                </div>
				<div class="form-group">
					<button id="add-product-submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>

	</div>
	<div class="row">
		<div class="col-md-12">
			<?php //\tsr\Db::insert_to_base() ?>
		</div>
	</div>
</div>