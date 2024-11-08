<?php

/*
 *       _____ _____ _____                _       _
 *      |_   _/  __ \_   _|              (_)     | |
 *        | | | /  \/ | |  ___  ___   ___ _  __ _| |
 *        | | ||      | | / __|/ _ \ / __| |/ _` | |
 *       _| |_| \__/\ | |_\__ \ (_) | (__| | (_| | |
 *      |_____\_____/ |_(_)___/\___/ \___|_|\__,_|_|
 *                   ___
 *                  |  _|___ ___ ___
 *                  |  _|  _| -_| -_|  LICENCE
 *                  |_| |_| |___|___|
 *
 * IT NEWS  <>  PROGRAMMING  <>  HW & SW  <>  COMMUNITY
 *
 * This source code is part of online courses at IT social
 * network WWW.ICT.SOCIAL
 *
 * Feel free to use it for whatever you want, modify it and share it but
 * don't forget to keep this link in code.
 *
 * For more information visit http://www.ict.social/licences
 */

/**
 * A base controller for ICT.social MVC
 * Class Controller
 */
abstract class Controller
{

    /** @var array An array which indexes will be accessible as variables in template */
    protected array $data = [];

    /** @var string A template name without the extension */
    protected string $view = "";

    /** @var array The HTML head */
	protected array $head = ['title' => '', 'description' => ''];

    /** Renders the view*/
    public function renderView(): void
    {
        if ($this->view)
        {
            extract($this->data);
            require("views/" . $this->view . ".phtml");
        }
    }

    /** @param $url string to a given URL */
	public function redirect(string $url): void
	{
		header("Location: /$url");
		header("Connection: close");
        exit;
	}

    /** @param array $params URL parameters */
    abstract function process(array $params): void;

}
