<?php
declare(strict_types=1);
namespace ErickFinancas\Repository;

use Illuminate\Database\Eloquent\Model;

class DefaultRepository implements RepositoryInterface
{

    /**
     * Summary of modelClass
     * @var ModelClass
     */
    private $modelClass;
    /**
     * Summary of model
     * @var Model
     */
    private $model;

    public function __construct(string $modelClass)
    {
        $this->$modelClass = $modelClass;
        $this->model = new $modelClass;
    }

	/**
	 * @return array
	 */
	public function all() : array {
        return $this->model->all()->toArray();
	}
	
	/**
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data) 
    {
        $this->model->fill($data);
        $this->model->save();
        return $this->model;
	}
	
	/**
	 *
	 * @param int $id
	 * @param array $data
	 * @return mixed
	 */
	public function update(int $id, array $data) 
    {
        $model = $this->find($id);
        $model->fill($data);
        $model->save();
        return $model;

	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function delete(int $id)
    {
        $model = $this->find($id);
        $model->delete();
	}
	/**
	 * @param int $id
	 * @return mixed
	 */
	public function find(int $id) 
    {
        return $this->model->findOrFail($id);
	}
}