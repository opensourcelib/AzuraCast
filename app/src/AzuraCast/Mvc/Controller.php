<?php
namespace AzuraCast\Mvc;

use AzuraCast\Acl\StationAcl;

class Controller extends \App\Mvc\Controller
{
    /** @var StationAcl */
    protected $acl;

    public function init()
    {
        if ($this->em->getRepository('Entity\Settings')->getSetting('setup_complete', 0) == 0) {
            return $this->redirectToRoute(['module' => 'frontend', 'controller' => 'setup']);
        }

        return parent::init();
    }

    /**
     * Overridable permissions check. Return false to generate "access denied" message.
     * @return bool
     */
    protected function permissions()
    {
        return $this->auth->isLoggedIn();
    }

    protected function preDispatch()
    {
        // Default to forbidding iframes
        $this->response = $this->response->withHeader('X-Frame-Options', 'DENY');
    }
}