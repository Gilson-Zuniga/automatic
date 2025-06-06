<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos

        //Facturas Clientes
        $verFacturasClientes = Permission::create(['name' => 'facturas_clientes.index']);
        $crearFacturasClientes = Permission::create(['name' => 'facturas_clientes.create']);
        $editarFacturasClientes = Permission::create(['name' => 'facturas_clientes.update']);
        $eliminarFacturasClientes = Permission::create(['name' => 'facturas_clientes.delete']);
        
        // Factura Proveedores
        $verFacturasProveedores = Permission::create(['name' => 'facturas_proveedores.index']);
        $crearFacturasProveedores = Permission::create(['name' => 'facturas_proveedores.create']);
        $editarFacturasProveedores = Permission::create(['name' => 'facturas_proveedores.update']);
        $eliminarFacturasProveedores = Permission::create(['name' => 'facturas_proveedores.delete']);

        // Proveedores
        $verProveedores = Permission::create(['name' => 'proveedores.index']);
        $crearProveedores = Permission::create(['name' => 'proveedores.create']);
        $editarProveedores = Permission::create(['name' => 'proveedores.update']);
        $eliminarProveedores = Permission::create(['name' => 'proveedores.delete']);

        // Productos
        $verProductos = Permission::create(['name' => 'productos.index']);
        $crearProductos = Permission::create(['name' => 'productos.create']);
        $editarProductos = Permission::create(['name' => 'productos.update']);
        $eliminarProductos = Permission::create(['name' => 'productos.delete']);
        
        // Categorias
        $verCategorias = Permission::create(['name' => 'categorias.index']);
        $crearCategoriass = Permission::create(['name' => 'categorias.create']);
        $editarCategoriass = Permission::create(['name' => 'categorias.update']);
        $eliminarCategoriass = Permission::create(['name' => 'categorias.delete']);

        // Tipo de Articulos
        $verTiposArticulos = Permission::create(['name' => 'tipoArticulos.index']);
        $crearTiposArticulos = Permission::create(['name' => 'tipoArticulos.create']);
        $editarTiposArticulos = Permission::create(['name' => 'tipoArticulos.update']);
        $eliminarTiposArticulos = Permission::create(['name' => 'tipoArticulos.delete']);

        // Catalogo
        $verCatalogo = Permission::create(['name' => 'catalogo.index']);
        $crearCatalogo = Permission::create(['name' => 'catalogo.create']);
        $editarCatalogo = Permission::create(['name' => 'catalogo.update']);
        $eliminarCatalogo = Permission::create(['name' => 'catalogo.delete']);
        
        // Inventario
        $verInventario = Permission::create(['name' => 'inventario.index']);
        $crearInventario = Permission::create(['name' => 'inventario.create']);
        $editarInventario = Permission::create(['name' => 'inventario.update']);
        $eliminarInventario = Permission::create(['name' => 'inventario.delete']);
        
        // Perfil Empresa
        $verPerfilEmpresa = Permission::create(['name' => 'perfilEmpresas.index']);
        $crearPerfilEmpresa = Permission::create(['name' => 'perfilEmpresas.create']);
        $editarPerfilEmpresa = Permission::create(['name' => 'perfilEmpresas.update']);
        $eliminarPerfilEmpresa = Permission::create(['name' => 'perfilEmpresas.delete']);

        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $cliente = Role::create(['name' => 'cliente']);
        $auxiliar = Role::create(['name' => 'auxiliar']);

        // Asignar permisos a roles
        $admin->syncPermissions(Permission::all());


        $cliente->givePermissionTo([
            $verFacturasClientes,
            $crearFacturasClientes
        ]);

        $auxiliar->givePermissionTo([
            $verFacturasClientes,
            $verCatalogo,
            $verProductos,
            $verCategorias,
            $verTiposArticulos,
            $verInventario,
            $verProveedores,
            $verFacturasProveedores,
            $crearFacturasProveedores,
            $crearFacturasClientes,
            
        ]);
    }
}
