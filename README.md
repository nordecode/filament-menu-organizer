# Filament Menu Organizer

Este projeto é uma versão traduzida e adaptada do [Filament Menu Builder](https://github.com/datlechin/filament-menu-builder) criado por [Ngo Quoc Dat](https://github.com/datlechin).


[![Última Versão no Packagist](https://img.shields.io/packagist/v/datlechin/filament-menu-builder.svg?style=flat-square)](https://packagist.org/packages/datlechin/filament-menu-builder)
[![Downloads Totais](https://img.shields.io/packagist/dt/datlechin/filament-menu-builder.svg?style=flat-square)](https://packagist.org/packages/datlechin/filament-menu-builder)

Este pacote para [Filament](https://filamentphp.com) permite que você crie e gerencie menus em sua aplicação Filament.

![Filament Menu Builder](https://github.com/datlechin/filament-menu-builder/raw/main/art/menu-builder.jpg)

> [!NOTA]
> Este fork foi criado para atender às necessidades específicas da Nordecode, incluindo a tradução para o português do Brasil e outras adaptações. Contribuições são bem-vindas!

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require nordecode/filament-menu-organizer
```

Você precisa publicar as migrações e executá-las:

```bash
php artisan vendor:publish --tag="filament-menu-organizer-migrations"
php artisan migrate
```

Você pode publicar o arquivo de configuração com:

```bash
php artisan vendor:publish --tag="filament-menu-organizer-config"
```

Opcionalmente, se você quiser personalizar as views, pode publicá-las com:

```bash
php artisan vendor:publish --tag="filament-menu-organizer-views"
```

Este é o conteúdo do arquivo de configuração publicado:

```php
return [
    'tables' => [
        'menus' => 'menus',
        'menu_items' => 'menu_items',
        'menu_locations' => 'menu_locations',
    ],
];
```

Adicione o plugin ao `AdminPanelProvider`:

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

$panel
    ...
    ->plugin(FilamentMenuOrganizerPlugin::make())
```

## Uso

### Adicionando locais

Locais são os lugares onde você pode exibir menus no frontend. Você pode adicionar locais no `AdminPanelProvider`:

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addLocation('cabecalho', 'Cabeçalho')
            ->addLocation('rodape', 'Rodapé')
    )
```

O primeiro argumento é a chave do local, e o segundo argumento é o título do local.

Alternativamente, você pode adicionar locais usando um array:

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addLocations([
                'header' => 'Cabeçalho',
                'footer' => 'Rodapé',
            ])
    )
```

### Configurando Painéis de Menu

Painéis de menu são os painéis que contêm os itens de menu que você pode adicionar aos menus.

#### Painel de Menu Personalizado

Por padrão, o pacote fornece um painel de menu **Link Personalizado** que permite adicionar links personalizados aos menus.

![Painel de Menu Link Personalizado](https://github.com/datlechin/filament-menu-builder/raw/main/art/custom-link.png)

#### Painel de Menu Estático

O painel de menu estático permite adicionar itens de menu manualmente.

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Nordecode\FilamentMenuOrganizer\MenuPanel\StaticMenuPanel;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addMenuPanels([
                StaticMenuPanel::make()
                    ->add('Início', url('/'))
                    ->add('Blog', url('/blog')),
            ])
    )
```

Da mesma forma que os locais, você também pode adicionar itens de menu estáticos usando um array:

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Nordecode\FilamentMenuOrganizer\MenuPanel\StaticMenuPanel;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addMenuPanels([
                StaticMenuPanel::make()
                    ->addMany([
                        'Início' => url('/'),
                        'Blog' => url('/blog'),
                    ])
            ])
    )
```

![Painel de Menu Estático](https://github.com/datlechin/filament-menu-builder/raw/main/art/static-menu.png)

#### Painel de Menu de Modelo

O painel de menu de modelo permite adicionar itens de menu a partir de um modelo.

Para criar um painel de menu de modelo, seu modelo deve implementar a interface `\Nordecode\FilamentMenuOrganizer\Contracts\MenuPanelable` e o trait `\Nordecode\FilamentMenuOrganizer\Concerns\HasMenuPanel`.

Em seguida, você precisará implementar os seguintes métodos:

```php
use Illuminate\Database\Eloquent\Model;
use Nordecode\FilamentMenuOrganizer\Concerns\HasMenuPanel;
use Nordecode\FilamentMenuOrganizer\Contracts\MenuPanelable;

class Category extends Model implements MenuPanelable
{
    use HasMenuPanel;

    public function getMenuPanelTitleColumn(): string
    {
        return 'title';
    }

    public function getMenuPanelUrlUsing(): callable
    {
        return fn (self $model) => route('category.show', $model->slug);
    }
}
```

Então você pode adicionar o painel de menu de modelo ao plugin:

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Nordecode\FilamentMenuOrganizer\MenuPanel\ModelMenuPanel;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addMenuPanels([
                ModelMenuPanel::make()
                    ->model(\App\Models\Category::class),
            ])
    )
```

![Painel de Menu de Modelo](https://github.com/datlechin/filament-menu-builder/raw/main/art/model-menu.png)

#### Opções Adicionais de Painel de Menu

Ao registrar um painel de menu, vários métodos estão disponíveis permitindo configurar o comportamento do painel, como estado de colapso e paginação.

```php
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;
use Nordecode\FilamentMenuOrganizer\MenuPanel\StaticMenuPanel;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addMenuPanels([
                StaticMenuPanel::make()
                    ->addMany([
                        ...
                    ])
                    ->description('Lorem ipsum...')
                    ->icon('heroicon-m-link')
                    ->collapsed(true)
                    ->collapsible(true)
                    ->paginate(perPage: 5, condition: true)
            ])
    )
```

### Campos Personalizados

Em alguns casos, você pode querer estender menus e itens de menu com campos personalizados. Para fazer isso, comece passando um array de componentes de formulário para os métodos `addMenuFields` e `addMenuItemFields` ao registrar o plugin:

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->addMenuFields([
                Toggle::make('is_logged_in')->label('Requer login'),
            ])
            ->addMenuItemFields([
                TextInput::make('classes')->label('Classes CSS'),
            ])
    )
```

Em seguida, crie uma migração adicionando as colunas adicionais às tabelas apropriadas:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações.
     */
    public function up(): void
    {
        Schema::table(config('filament-menu-organizer.tables.menus'), function (Blueprint $table) {
            $table->boolean('is_logged_in')->default(false);
        });

        Schema::table(config('filament-menu-organizer.tables.menu_items'), function (Blueprint $table) {
            $table->string('classes')->nullable();
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {
        Schema::table(config('filament-menu-organizer.tables.menus'), function (Blueprint $table) {
            $table->dropColumn('is_logged_in');
        });

        Schema::table(config('filament-menu-organizer.tables.menu_items'), function (Blueprint $table) {
            $table->dropColumn('classes');
        });
    }
}
```

Depois de concluído, basta executar `php artisan migrate`.

### Personalizando o Recurso

Por padrão, um Recurso de Menu padrão é registrado no Filament ao registrar o plugin no provedor de administração. Este recurso pode ser estendido e substituído, permitindo um controle mais refinado.

Comece estendendo a classe `Nordecode\FilamentMenuOrganizer\Resources\MenuResource` em sua aplicação. Abaixo está um exemplo:

```php
namespace App\Filament\Plugins\Resources;

use Nordecode\FilamentMenuOrganizer\Resources\MenuResource as BaseMenuResource;

class MenuResource extends BaseMenuResource
{
    protected static ?string $navigationGroup = 'Navegação';

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }
}
```

Agora passe o recurso personalizado para `usingResource` ao registrar o plugin no painel:

```php
use App\Filament\Plugins\Resources\MenuResource;
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->usingResource(MenuResource::class)
    )
```

### Personalizando os Modelos

Os modelos padrão usados pelo plugin podem ser configurados e substituídos de maneira semelhante ao recurso do plugin, como visto acima.

Simplesmente estenda os modelos padrão e passe as classes ao registrar o plugin no painel:

```php
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use Nordecode\FilamentMenuOrganizer\FilamentMenuOrganizerPlugin;

$panel
    ...
    ->plugin(
        FilamentMenuOrganizerPlugin::make()
            ->usingMenuModel(Menu::class)
            ->usingMenuItemModel(MenuItem::class)
            ->usingMenuLocationModel(MenuLocation::class)
    )
```

### Usando Menus

Obter o menu atribuído a um local registrado pode ser feito usando o modelo `Menu`. Abaixo, chamaremos o menu atribuído ao local `primary`:

```php
use Nordecode\FilamentMenuOrganizer\Models\Menu;

$menu = Menu::location('primary');
```

Os itens de menu podem ser iterados a partir do relacionamento `menuItems`:

```php
@foreach ($menu->menuItems as $item)
    <a href="{{ $item->url }}">{{ $item->title }}</a>
@endforeach
```

Quando um item de menu é pai, uma coleção dos itens de menu filhos estará disponível na propriedade `children`:

```php
@foreach ($menu->menuItems as $item)
    <a href="{{ $item->url }}">{{ $item->title }}</a>

    @if ($item->children)
        @foreach ($item->children as $child)
            <a href="{{ $child->url }}">{{ $child->title }}</a>
        @endforeach
    @endif
@endforeach
```

## Registro de Alterações

Por favor, veja [CHANGELOG](CHANGELOG.md) para mais informações sobre o que mudou recentemente.

## Contribuindo

Por favor, veja [CONTRIBUTING](.github/CONTRIBUTING.md) para detalhes.

## Vulnerabilidades de Segurança

Por favor, revise [nossa política de segurança](../../security/policy) sobre como reportar vulnerabilidades de segurança.

## Créditos

- [Ngo Quoc Dat](https://github.com/datlechin)
- [Log1x](https://github.com/Log1x)
- [Todos os Contribuidores](../../contributors)

## Licença

Este projeto é licenciado sob os termos da licença MIT.

### Nota sobre a licença
Este fork mantém a licença original MIT do projeto Filament Menu Builder. Reconhecemos e respeitamos o trabalho original de Ngo Quoc Dat.
Quaisquer modificações ou adições feitas neste fork estão também sob a licença MIT, em conformidade com os termos da licença original.
Para mais detalhes, consulte o arquivo [LICENSE](LICENSE.md) neste repositório.

### Créditos

- Projeto original: [datlechin/filament-menu-builder](https://github.com/datlechin/filament-menu-builder)
- Autor original: [Ngo Quoc Dat](https://github.com/datlechin)
- Adaptação e tradução: [Nordecode](https://github.com/nordecode)
