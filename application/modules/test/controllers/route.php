<?php
/**
 * Route examples
 *
 * @author   Anton Shevchuk
 * @created  12.06.12 13:08
 */
namespace Application;
use Bluz;

return
/**
 * @return \closure
 */
function() use ($view) {

    $this->getLayout()->breadCrumbs([
        $view->ahref('Test', ['test', 'index']),
        'Routers Examples',
    ]);
};
