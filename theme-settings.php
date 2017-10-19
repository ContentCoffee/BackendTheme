<?php

function backendtheme_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = null)
{
    // Work-around for a core bug affecting admin themes. See issue #943212.
    if (isset($form_id)) {
        return;
    }

    if (\Drupal::service('module_handler')->moduleExists('backendtheme_admin_toolbar')){
        $form['admin_toolbar'] = [
          '#type' => 'details',
          '#attributes' => ['class' => ['styles']],
          '#title' => t('Toolbar settings'),
          '#weight' => -899,
          '#group' => 'toolbar',
          '#open' => TRUE,
          '#tree' => TRUE,
        ];

        $form['admin_toolbar']['toolbar_theme'] = [
          '#type' => 'select',
          '#options' => [
            'light' => t('Light'),
            'dark' => t('Dark'),
          ],
          '#title' => t('Toolbar Theme'),
          '#default_value' => \Drupal::config('backendtheme.settings')->get('toolbar.theme'),
          '#description' => t('The theme for the toolbar'),
        ];

        $form['#submit'][] = 'backendtheme_form_settings_submit';
    }

    $form['options'] = [
      '#type' => 'details',
      '#attributes' => ['class' => ['styles']],
      '#title' => t('backendtheme options'),
      '#weight' => -899,
      '#group' => 'backendtheme_options',
      '#open' => TRUE,
      '#tree' => TRUE,
    ];

    $form['options']['breadcrumb_show'] = [
      '#type' => 'checkbox',
      '#title' => t('Show breadcrumbs'),
      '#default_value' => \Drupal::config('backendtheme.settings')->get('breadcrumbs.show'),
      '#description' => t('The theme for the toolbar'),
    ];
}

function backendtheme_form_settings_submit(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $toolbar_values = $form_state->getValue('admin_toolbar');
    \Drupal::service('config.factory')->getEditable('backendtheme.settings')->set('toolbar.theme', $toolbar_values['toolbar_theme'])->save();

    $breadcrumbs_values = $form_state->getValue('options');
    \Drupal::service('config.factory')->getEditable('backendtheme.settings')->set('breadcrumbs.show', $breadcrumbs_values['breadcrumb_show'])->save();
}
