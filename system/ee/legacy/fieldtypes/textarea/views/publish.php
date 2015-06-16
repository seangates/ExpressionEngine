<?php
$attributes = array(
	'name'	=> $name,
	'value'	=> $value,
	'rows'	=> $settings['field_ta_rows'],
	'dir'	=> $settings['field_text_direction'],
	'class' => $class
);

if (isset($settings['field_show_formatting_btns']) && $settings['field_show_formatting_btns'] == 'y')
{
	$attributes['data-markitup'] = 'yes';
}
?>
<?=form_textarea($attributes);?>
<?php if ($toolbar): ?>
<div class="format-options">
	<ul class="toolbar">
		<?php if (isset($settings['field_show_file_selector']) && $settings['field_show_file_selector'] == 'y'): ?>
		<li class="upload"><a class="m-link textarea-field-filepicker" href="<?=$fp_url?>" rel="modal-file" title="<?=lang('upload_file')?>" rel="modal-file" data-input-value="<?=$name?>"></a></li>
		<?php endif; ?>
		<?php if ($smileys_enabled && isset($settings['field_show_smileys']) && $settings['field_show_smileys'] == 'y'): ?>
		<li class="emoji"><a href="" title="<?=lang('open_emoji')?>"></a></li>
		<?php endif; ?>
		<?php if (isset($settings['field_show_fmt']) && $settings['field_show_fmt'] == 'y'): ?>
		<li class="form-element">
			<?=form_dropdown('field_ft_'.$settings['field_id'], $format_options, $settings['field_fmt'])?>
		</li>
		<?php endif; ?>
	</ul>

	<?php if ($smileys_enabled && isset($settings['field_show_smileys']) && $settings['field_show_smileys'] == 'y'): ?>
		<div class="emoji-wrap">
			<?=$smileys?>
		</div>
	<?php endif; ?>
</div>
<?php endif; ?>