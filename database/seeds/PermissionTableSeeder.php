<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $permissions = [
           'voir-administration',
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'boutique-list',
           'boutique-create',
           'boutique-edit',
           'boutique-delete',
           'magasin-list',
           'magasin-create',
           'magasin-edit',
           'magasin-delete',
           'categorie-list',
           'categorie-create',
           'categorie-edit',
           'categorie-delete',
           'produit-list',
           'produit-create',
           'produit-edit',
           'produit-delete',
           'magasin-jour-list',
           'magasin-jour-create',
           'magasin-jour-edit',
           'magasin-jour-delete',
           'magasin-jour-close',
           'magasin-jour-open',
           'boutique-jour-list',
           'boutique-jour-create',
           'boutique-jour-edit',
           'boutique-jour-delete',
           'vente-boutique-list',
           'vente-boutique-create',
           'vente-boutique-edit',
           'vente-boutique-delete',
           'solde-boutique-list',
           'solde-boutique-create',
           'solde-boutique-edit',
           'solde-boutique-delete',
           'charge-boutique-list',
           'charge-boutique-create',
           'charge-boutique-edit',
           'charge-boutique-delete',
           'tontine-boutique-list',
           'tontine-boutique-create',
           'tontine-boutique-edit',
           'tontine-boutique-delete',
           'versement-boutique-list',
           'versement-boutique-create',
           'versement-boutique-edit',
           'versement-boutique-delete',
           'dette-boutique-list',
           'dette-boutique-create',
           'dette-boutique-edit',
           'dette-boutique-delete',
           'boutique-magasin-sortie-list',
           'boutique-magasin-sortie-create',
           'boutique-magasin-sortie-edit',
           'boutique-magasin-sortie-delete',
           'boutique-comptabilite',
           'magasin-comptabilite',
           'magasin-entree-list',
           'magasin-entree-create',
           'magasin-entree-edit',
           'magasin-entree-delete',
           'magasin-stocks-list',
           'magasin-historiques-list',
           'boutique-historiques-list',
           'boutique-stocks-list',
           'boutique-jour-close',
           'boutique-jour-open',
           'magasin-magasin-sortie-list',
           'magasin-magasin-sortie-create',
           'magasin-magasin-sortie-edit',
           'magasin-magasin-sortie-delete',
           'magasin-boutique-sortie-list',
           'magasin-boutique-sortie-create',
           'magasin-boutique-sortie-edit',
           'magasin-boutique-sortie-delete',
           'boutique-inventaire-list',
           'magasin-inventaire-list'
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
