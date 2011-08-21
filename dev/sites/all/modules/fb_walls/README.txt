This light weight module allows you to show facebook walls of diffent users, pages or apps in a block. You can configure as many walls as you'd like. Each wall provides an own block.
This drupal module uses the jquery plugin developed by neosmart (http://www.neosmart.de/social-media/fb-wall) to retrive and show the facebook walls. 

--- Installation ---
Just place the module into your sites module folder, in most cases /sites/all/modules, and enable it on the admin  module page /admin/build/modules.

--- Configuration and usage ---
First you have to set up one or multiple facebook walls in the admin area at /admin/settings/fb_walls
See http://www.neosmart.de/social-media/fb-wall for more details of the given paramters.
After you have set up you wall configuration, go to the drupal block administration page and configure your block at /admin/build/block
The blocks provided by the facebook walls module are named "FB Wall: [FBID]"

--- CCK integration ---
If you use the CCK Module, you can add a Facebook Wall field and a Facebook Wall Widget. So you can add as many Facebook Walls as you would like to any node that contains a FB Wall Field. Multiple Fields are supported to.
In a special usecase you could make a certain node type the content profile and add the FB Wall field to it so every user could show his Facebook wall in his profile.

--- Maintainer ---
The maintainer of this module is manuelBS
