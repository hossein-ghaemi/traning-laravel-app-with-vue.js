<?php
namespace App\Helpers;
use App\Models\Role;
use Illuminate\Routing\Route;

class RouteHelper{

    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
        return $this;

    }

    /**
     * Add or change the route action.
     *
     * @param  string  $key
     * @param  string  $value
     * @return $this
     */
    public function addAction($key, $value)
    {
        $this->route->action[$key] = $value;
        return  $this;
    }

    /**
     * Add or change the route title.
     *
     * @param  string  $title
     * @return $this
     */
    public function addTitle($title)
    {
        return $this->addAction('title', $title);
    }

    /**
     * Add or change the route access Role.
     *
     * @param  string  $role
     * @return $this
     */
    public function addAccessRole($role)
    {
        return $this->addAction('role', $role);
    }

    /**
     * Add or change the route Access Status.
     *
     * @param  string  $status
     * @return $this
     */
    public function addAccessStatus(Bool $status)
    {
        return $this->addAction('status', $status);
    }

    /**
     * Add or change the route Access Default for selected role.
     *
     * @param  string  $status
     * @return $this
     */
    public function addAccessDefult(Bool $def_access)
    {
        return $this->addAction('def_access', $def_access);
    }

}
