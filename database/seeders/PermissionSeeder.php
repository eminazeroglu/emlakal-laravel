<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionPivotGroup;
use App\Models\Translate;
use App\Services\Models\LanguageService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    private $options = ['create', 'read', 'update', 'delete', 'action'];

    private $names = [
        'language'     => 'Dil və tərcümə idarəetməsi',
        'user'         => 'İstifadəçi idarəetməsi',
        'permission'   => 'Səlahiyyət idarəetməsi',
        'setting'      => 'Ayarlar idarəetməsi',
        'seo_meta_tag' => 'Seo idarəetməsi',
        'menu'         => 'Menular idarəetməsi',
    ];

    public function permissions(): array
    {
        $result = [];
        $router = collect(Route::getRoutes())
            ->map(fn($i) => $i->uri)
            ->filter(fn($i) => str($i)->startsWith('api/crud'))
            ->map(function ($i) {
                $item = str_replace('api/crud', null, $i);
                return snake_case(camel_case(array_first(array_values(array_filter(explode('/', $item))))));
            })
            ->filter(fn($i) => $i !== 'translates')
            ->unique();
        foreach ($router as $i):
            $key = str($i)->singular()->value();
            $result[] = [
                'key'     => $key,
                'name'    => 'crm.Permission.Main.' . str_replace(' ', '', str($key)->headline()) . 'Management',
                'text'    => $this->names[$key] ?? '',
                'options' => $this->options
            ];
        endforeach;
        return $result;
    }

    public function groups(): array
    {
        return [
            [
                'name' => 'İstifadəçi'
            ],
            [
                'name' => 'Admin'
            ]
        ];
    }

    public function run()
    {

        $permissions = $this->permissions();
        $groups      = $this->groups();

        Schema::disableForeignKeyConstraints();
        $permission_model = new Permission();
        $permission_model->truncate();
        $group_model = new PermissionGroup();
        $group_model->truncate();
        $pivot_model = new PermissionPivotGroup();
        $pivot_model->truncate();
        $translate_model = new Translate();

        foreach ($groups as $group):
            $languages  = (new LanguageService())->findActiveList();
            $translates = [];
            foreach ($languages as $language):
                $translates[$language['code']] = ['name' => $group['name']];
            endforeach;
            $group_model->insert([
                'translates' => json_encode($translates),
                'url'        => str()->slug($group['name']),
                'is_active'  => 1
            ]);
        endforeach;

        foreach ($permissions as $permission):
            $permission_id = $permission_model->insertGetId([
                'translate_name' => $permission['name'],
                'key'            => str($permission['key'])->singular(),
                'option_field'   => json_encode($permission['options']),
            ]);
            $translate_model->insert([
                'key'  => $permission['name'],
                'text' => $permission['text'],
            ]);
            $options = [];
            foreach ($permission['options'] as $option):
                $options[$option] = true;
            endforeach;
            $pivot_model->insert([
                'permission_id' => $permission_id,
                'group_id'      => 2,
                'option_field'  => json_encode($options)
            ]);
        endforeach;

        foreach ($this->options as $option):
            $createKey = 'crm.Permission.Option.' . ucfirst($option);
            $text      = '';
            if ($option === 'create')
                $text = 'Yaratma';
            else if ($option === 'read')
                $text = 'Oxuma';
            else if ($option === 'update')
                $text = 'Dəyişdirmə';
            else if ($option === 'delete')
                $text = 'Silmə';
            else if ($option === 'action')
                $text = 'Digər fəaliyyətlər';

            $findTranslate = $translate_model->where('key', $createKey)->exists();
            if (!$findTranslate):
                $translate_model->insert([
                    'key'  => $createKey,
                    'text' => $text
                ]);
            endif;
        endforeach;
        helper()->cacheRemove('translates');
        Schema::enableForeignKeyConstraints();
    }
}
