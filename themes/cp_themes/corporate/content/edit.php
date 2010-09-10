<?php
if ($EE_view_disable !== TRUE)
{
	$this->load->view('_shared/header');
	$this->load->view('_shared/main_menu');
	$this->load->view('_shared/sidebar');
	$this->load->view('_shared/breadcrumbs');
}
?>

<div id="mainContent"<?=$maincontent_state?>>
	<?php $this->load->view('_shared/right_nav')?>
	<div class="contents">
		
		<div class="heading">
			<h2>
			<span id="filter_ajax_indicator"><img src="<?=$cp_theme_url?>images/indicator2.gif" /></span>
			<?=lang($heading)?></h2>			
		</div>		
		
		<div class="pageContents">

		<div id="filterMenu">

			<?php $this->load->view('_shared/message');?>

			<?=form_open($search_form, array('name'=>'filterform', 'id'=>'filterform'), $search_form_hidden)?>

				<div class="group">
					<?=form_dropdown('channel_id', $channel_select_options, $channel_selected, 'id="f_channel_id"').NBS.NBS?>
					<?=form_dropdown('cat_id', $category_select_options, $category_selected, 'id="f_cat_id"').NBS.NBS?>
					<?=form_dropdown('status', $status_select_options, $status_selected, 'id="f_status"').NBS.NBS?>
					<?=form_dropdown('date_range', $date_select_options, $date_selected, 'id="date_range"').NBS.NBS?>
					<?php
						// JS required theme, so ordering handled by table sorter
						//form_dropdown('order', $order_select_options, $order_selected, 'id="f_select_options"').NBS.NBS
					?>

					<?=form_dropdown('perpage', $perpage_select_options, $perpage_selected, 'id="f_perpage"')?>
				</div>

        		<div id="custom_date_picker" style="display: none; margin: 0 auto 50px auto;width: 500px; height: 235px; padding: 5px 15px 5px 15px;border: 1px solid black;  background: #FFF;">
					<div id="cal1" style="width:250px; float:left; text-align:center;">
						<p style="text-align:left; margin-bottom:5px"><?=lang('start_date', 'custom_date_start')?>:&nbsp; <input type="text" name="custom_date_start" id="custom_date_start" value="yyyy-mm-dd" size="12" tabindex="1" /></p>
						<span id="custom_date_start_span"></span>
					</div>
	                <div id="cal2" style="width:250px; float:left; text-align:center;">
						<p style="text-align:left; margin-bottom:5px"><?=lang('end_date', 'custom_date_end')?>:&nbsp; <input type="text" name="custom_date_end" id="custom_date_end" value="yyyy-mm-dd" size="12" tabindex="2" /></p>
						<span id="custom_date_end_span"></span>          
					</div>
                </div>

				<div>
					<?=lang('keywords', 'keywords')?> <?=form_input($keywords).NBS.NBS?>
					<?=form_checkbox('exact_match', 'yes', $exact_match, 'id="exact_match"')?> <?=lang('exact_match', 'exact_match').NBS.NBS?>
					<?=form_dropdown('search_in', $search_in_options, $search_in_selected, 'id="f_search_in"').NBS.NBS?>
					<?=form_submit('submit', lang('search'), 'class="submit" id="search_button"')?>
				</div>

			<?=form_close()?>
	
			</div> <!-- filterMenu -->

			<?php if ($total_count == 0):?>
				<div class="tableFooter">
					<p class="notice"><?=lang('no_entries_matching_that_criteria')?></p>
				</div>
			<?php else:?>

				<?=form_open($entries_form, array('id' => 'entries_form'), $form_hidden)?>

				<?php
					$this->table->set_template($cp_table_template);
					$this->table->set_heading($table_headings);

					echo $this->table->generate($entries);
				?>
			<?php if ($autosave_show):?>
				<p class="notice"><?=required()?><?=lang('autosave_data_available')?></p>
			<?php endif;?>

			<div class="tableSubmit">
				<?=form_submit('submit', lang('submit'), 'class="submit"').NBS.NBS?>
				<?php if (count($action_options) > 0):?>
				<?=form_dropdown('action', $action_options).NBS.NBS?>
				<?php endif;?>
			</div>

		

		</div> <!-- tableFooter -->

			<?php endif; /* if $total_count > 0*/?>

		<?=form_close()?>
			</div> <!-- pageContents -->
	</div> <!-- contents -->
</div> <!-- mainContent -->

<?php
if ($EE_view_disable !== TRUE)
{
	$this->load->view('_shared/accessories');
	$this->load->view('_shared/footer');
}

/* End of file edit.php */
/* Location: ./themes/cp_themes/corporate/content/edit.php */