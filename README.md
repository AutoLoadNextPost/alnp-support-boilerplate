# Auto Load Next Post: Support Boilerplate

Boilerplate for providing theme support for Auto Load Next Post via a plugin.

## Requires
* Auto Load Next Post v1.5.0 or above.


## How to Configure

There are four areas available for setting up once you have forked this boilerplate. While the first is not required, it does help with the out of the box experience for the users.

#### 1. Theme Selectors

If they are predefined to the theme you are supporting then they will be applied automatically when this plugin is activated. This way the user does not have to do it themselves.

Change only the theme selectors that need changing. Leave the others as they are.

![Add Theme Support](https://raw.githubusercontent.com/AutoLoadNextPost/alnp-support-boilerplate/master/add-theme-support.png)

#### 2. Template Location

The template location is only needed to be filtered should the templates not be located in the parent directory of the theme. To enable the filter to change the location of the templates simply follow the instructions in the boilerplate code.

#### 3. Repeater Template

You can if you need provide with your own repeater template to match your theme. A copy of the repeater template has already been provided. To enable the filter to locate this template simply follow the instructions in the boilerplate code.

#### 4. JavaScript in Footer

For some themes Auto Load Next Post may not work if the JavaScript is placed in the header. Simply set the JavaScript to load in the footer instead and Auto Load Next Post will work just the same.

To set the JavaScript to load in the footer, simply change `load_js_in_footer` to `yes` when adding theme support. See screenshot above.

You may also if you so wish, to remove the option to disable load the JavaScript in the footer so users don't do so by mistake. This forces Auto Load Next Post to make sure the JavaScript loads in the footer only for the theme your supporting.

To remove the option to lock the JavaScript in the footer from the plugin settings, simply change `lock_js_in_footer` to `yes`.

