<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class ProductoController extends BaseController
{
    protected $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    public function index()
    {
        $data['productos'] = $this->productoModel
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('productos/index', $data);
    }

    public function crear()
    {
        return view('productos/crear');
    }

    public function guardar()
    {
        $this->productoModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'cantidad' => $this->request->getPost('cantidad')
        ]);

        return redirect()->to('/productos')
            ->with('mensaje', 'Producto registrado correctamente.');
    }

    public function editar($id)
    {
        $data['producto'] = $this->productoModel->find($id);

        if (!$data['producto']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('productos/editar', $data);
    }

    public function actualizar($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->productoModel->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'cantidad' => $this->request->getPost('cantidad')
        ]);

        return redirect()->to('/productos')
            ->with('mensaje', 'Producto actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->productoModel->delete($id);

        return redirect()->to('/productos')
            ->with('mensaje', 'Producto eliminado correctamente.');
    }
}