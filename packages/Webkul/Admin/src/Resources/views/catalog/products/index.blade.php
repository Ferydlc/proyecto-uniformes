<x-admin::layouts>
    <x-slot:title>
        Catálogo de Uniformes - Colegio Meze
    </x-slot>

    <!-- Header Section -->
    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                Catálogo de Uniformes y Accesorios
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Gestiona uniformes diarios, deportivos, de invierno y accesorios
            </p>
        </div>

        <div class="flex items-center gap-x-2.5">
            <!-- Filtros Rápidos -->
            <v-category-filter></v-category-filter>

            <!-- Export Modal -->
            <x-admin::datagrid.export :src="route('admin.catalog.products.index')" />

            <!-- Crear Producto -->
            @if (bouncer()->hasPermission('catalog.products.create'))
                <v-create-product-form>
                    <button
                        type="button"
                        class="primary-button flex items-center gap-2"
                    >
                        <span class="icon-add text-lg"></span>
                        Nuevo Producto
                    </button>
                </v-create-product-form>
            @endif
        </div>
    </div>

    <!-- Filtros de Categoría Rápidos -->
    <div class="mt-4 flex flex-wrap gap-2">
        <button class="rounded-lg border-2 border-[#1e3c72] bg-[#1e3c72] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#2a5298]">
            Todos los Productos
        </button>
        <button class="rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-[#1e3c72] hover:text-[#1e3c72] dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            Uniformes Diarios
        </button>
        <button class="rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-[#1e3c72] hover:text-[#1e3c72] dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            Uniformes Deportivos
        </button>
        <button class="rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-[#1e3c72] hover:text-[#1e3c72] dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            Uniformes de Invierno
        </button>
        <button class="rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-[#1e3c72] hover:text-[#1e3c72] dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            Accesorios
        </button>
        <button class="rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-[#1e3c72] hover:text-[#1e3c72] dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            Equipos de Fútbol
        </button>
    </div>

    <!-- Datagrid Mejorado -->
    <x-admin::datagrid
        :src="route('admin.catalog.products.index')"
        :isMultiRow="true"
    >
        <!-- Datagrid Header -->
        @php
            $hasPermission = bouncer()->hasPermission('catalog.products.edit') || bouncer()->hasPermission('catalog.products.delete');
        @endphp

        <template #header="{
            isLoading,
            available,
            applied,
            selectAll,
            sort,
            performAction
        }">
            <template v-if="isLoading">
                <x-admin::shimmer.datagrid.table.head :isMultiRow="true" />
            </template>

            <template v-else>
                <div class="row grid gap-2 md:grid-cols-[2fr_1fr_1fr] grid-rows-1 items-center border-b bg-gray-50 px-4 py-3 dark:border-gray-800 dark:bg-gray-900">
                    <div
                        class="flex select-none items-center gap-2.5"
                        v-for="(columnGroup, index) in [['name', 'sku'], ['base_image', 'price', 'quantity'], ['status', 'category_name', 'type']]"
                    >
                        @if ($hasPermission)
                            <label
                                class="flex w-max cursor-pointer select-none items-center gap-1"
                                for="mass_action_select_all_records"
                                v-if="! index"
                            >
                                <input
                                    type="checkbox"
                                    name="mass_action_select_all_records"
                                    id="mass_action_select_all_records"
                                    class="peer hidden"
                                    :checked="['all', 'partial'].includes(applied.massActions.meta.mode)"
                                    @change="selectAll"
                                >

                                <span
                                    class="icon-uncheckbox cursor-pointer rounded-md text-2xl"
                                    :class="[
                                        applied.massActions.meta.mode === 'all' ? 'peer-checked:icon-checked peer-checked:text-[#1e3c72]' : (
                                            applied.massActions.meta.mode === 'partial' ? 'peer-checked:icon-checkbox-partial peer-checked:text-[#1e3c72]' : ''
                                        ),
                                    ]"
                                >
                                </span>
                            </label>
                        @endif

                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="[&>*]:after:content-['_/_']">
                                <template v-for="column in columnGroup">
                                    <span
                                        class="after:content-['/'] last:after:content-['']"
                                        :class="{
                                            'font-bold text-[#1e3c72] dark:text-[#3b6bb8]': applied.sort.column == column,
                                            'cursor-pointer hover:text-[#1e3c72] dark:hover:text-[#3b6bb8]': available.columns.find(columnTemp => columnTemp.index === column)?.sortable,
                                        }"
                                        @click="
                                            available.columns.find(columnTemp => columnTemp.index === column)?.sortable ? sort(available.columns.find(columnTemp => columnTemp.index === column)): {}
                                        "
                                    >
                                        @{{ available.columns.find(columnTemp => columnTemp.index === column)?.label }}
                                    </span>
                                </template>
                            </span>

                            <i
                                class="align-text-bottom text-base text-[#1e3c72] dark:text-[#3b6bb8] ltr:ml-1.5 rtl:mr-1.5"
                                :class="[applied.sort.order === 'asc' ? 'icon-down-stat': 'icon-up-stat']"
                                v-if="columnGroup.includes(applied.sort.column)"
                            ></i>
                        </p>
                    </div>
                </div>
            </template>
        </template>

        <template #body="{
            isLoading,
            available,
            applied,
            selectAll,
            sort,
            performAction
        }">
            <template v-if="isLoading">
                <x-admin::shimmer.datagrid.table.body :isMultiRow="true" />
            </template>

            <template v-else>
                <div
                    class="row border-b px-2 py-3 transition-all hover:bg-blue-50 dark:border-gray-800 dark:hover:bg-gray-900 sm:px-4 md:grid md:grid-cols-[2fr_1fr_1fr] md:grid-rows-1 md:gap-1.5"
                    v-for="record in available.records"
                >
                    <!-- Mobile Layout -->
                    <div class="block space-y-3 md:hidden">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-2.5">
                                @if ($hasPermission)
                                    <input
                                        type="checkbox"
                                        :name="`mass_action_select_record_${record.product_id}`"
                                        :id="`mass_action_select_record_${record.product_id}`"
                                        :value="record.product_id"
                                        class="peer hidden"
                                        v-model="applied.massActions.indices"
                                    >

                                    <label
                                        class="icon-uncheckbox peer-checked:icon-checked cursor-pointer rounded-md text-2xl peer-checked:text-[#1e3c72]"
                                        :for="`mass_action_select_record_${record.product_id}`"
                                    ></label>
                                @endif

                                <!-- Imagen del producto mejorada -->
                                <div class="relative flex-shrink-0">
                                    <template v-if="record.base_image">
                                        <img
                                            class="h-20 w-20 rounded-lg border-2 border-gray-200 object-cover sm:h-24 sm:w-24"
                                            :src='record.base_image'
                                        />

                                        <span class="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full bg-[#1e3c72] text-xs font-bold text-white">
                                            @{{ record.images_count }}
                                        </span>
                                    </template>

                                    <template v-else>
                                        <div class="relative h-20 w-20 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-800 sm:h-24 sm:w-24">
                                            <img src="{{ bagisto_asset('images/product-placeholders/front.svg')}}" class="h-full w-full object-cover p-2">

                                            <p class="absolute bottom-1 w-full text-center text-[8px] font-semibold text-gray-400">
                                                Sin imagen
                                            </p>
                                        </div>
                                    </template>

                                    <!-- Badge de stock -->
                                    <div class="absolute -top-2 -left-2" v-if="record.quantity <= 0">
                                        <span class="rounded-full bg-red-500 px-2 py-1 text-xs font-bold text-white">
                                            Sin Stock
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5 flex-1">
                                    <p class="break-all text-base font-bold text-gray-800 dark:text-white">
                                        @{{ record.name }}
                                    </p>

                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                            <span class="icon-hashtag mr-1"></span>
                                            @{{ record.sku }}
                                        </span>
                                        
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            @{{ record.category_name ?? 'Sin categoría' }}
                                        </span>
                                    </div>

                                    <p class="text-lg font-bold text-[#1e3c72] dark:text-[#3b6bb8]">
                                        @{{ $admin.formatPrice(record.price) }}
                                    </p>

                                    <!-- Stock Info -->
                                    <div v-if="!['configurable', 'bundle', 'grouped' , 'booking'].includes(record.type)">
                                        <p class="text-sm" v-if="record.quantity > 0">
                                            <span class="font-semibold text-green-600">
                                                En stock: @{{ record.quantity }} piezas
                                            </span>
                                        </p>
                                        <p class="text-sm" v-else>
                                            <span class="font-semibold text-red-600">
                                                Sin existencias
                                            </span>
                                        </p>
                                    </div>

                                    <!-- Status Badge -->
                                    <div>
                                        <span v-if="record.status" class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">
                                            <span class="mr-1 h-2 w-2 rounded-full bg-green-600"></span>
                                            Activo
                                        </span>
                                        <span v-else class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-800">
                                            <span class="mr-1 h-2 w-2 rounded-full bg-gray-600"></span>
                                            Inactivo
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-1">
                                <span
                                    class="cursor-pointer rounded-md p-1.5 text-xl transition-all hover:bg-blue-100 dark:hover:bg-gray-800"
                                    :class="action.icon"
                                    v-text="! action.icon ? action.title : ''"
                                    v-for="action in record.actions"
                                    @click="performAction(action)"
                                >
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Layout -->
                    <div class="hidden md:contents">
                        <!-- Columna: Nombre y SKU -->
                        <div class="flex gap-3">
                            @if ($hasPermission)
                                <input
                                    type="checkbox"
                                    :name="`mass_action_select_record_${record.product_id}`"
                                    :id="`mass_action_select_record_${record.product_id}`"
                                    :value="record.product_id"
                                    class="peer hidden"
                                    v-model="applied.massActions.indices"
                                >

                                <label
                                    class="icon-uncheckbox peer-checked:icon-checked cursor-pointer rounded-md text-2xl peer-checked:text-[#1e3c72]"
                                    :for="`mass_action_select_record_${record.product_id}`"
                                ></label>
                            @endif

                            <div class="flex flex-col gap-2">
                                <p class="text-base font-bold text-gray-800 dark:text-white">
                                    @{{ record.name }}
                                </p>

                                <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                    <span class="icon-hashtag mr-1"></span>
                                    @{{ record.sku }}
                                </span>
                            </div>
                        </div>

                        <!-- Columna: Imagen, Precio y Stock -->
                        <div class="flex gap-3">
                            <!-- Imagen -->
                            <div class="relative">
                                <template v-if="record.base_image">
                                    <img
                                        class="h-20 w-20 rounded-lg border-2 border-gray-200 object-cover"
                                        :src='record.base_image'
                                    />

                                    <span class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-[#1e3c72] text-xs font-bold text-white">
                                        @{{ record.images_count }}
                                    </span>
                                </template>

                                <template v-else>
                                    <div class="relative h-20 w-20 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-800">
                                        <img src="{{ bagisto_asset('images/product-placeholders/front.svg')}}" class="p-2">
                                        <p class="absolute bottom-1 w-full text-center text-[8px] font-semibold text-gray-400">
                                            Sin imagen
                                        </p>
                                    </div>
                                </template>
                            </div>

                            <!-- Info -->
                            <div class="flex flex-col gap-1.5 justify-center">
                                <p class="text-lg font-bold text-[#1e3c72] dark:text-[#3b6bb8]">
                                    @{{ $admin.formatPrice(record.price) }}
                                </p>

                                <div v-if="!['configurable', 'bundle', 'grouped' , 'booking'].includes(record.type)">
                                    <p class="text-sm" v-if="record.quantity > 0">
                                        <span class="font-semibold text-green-600">
                                            Stock: @{{ record.quantity }}
                                        </span>
                                    </p>
                                    <p class="text-sm" v-else>
                                        <span class="font-semibold text-red-600">
                                            Sin stock
                                        </span>
                                    </p>
                                </div>
                                <div v-else>
                                    <span class="text-sm text-gray-500">N/A</span>
                                </div>
                            </div>
                        </div>

                        <!-- Columna: Status, Categoría y Acciones -->
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-2">
                                <!-- Status -->
                                <span v-if="record.status" class="inline-flex w-fit items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                    <span class="mr-1.5 h-2 w-2 rounded-full bg-green-600"></span>
                                    Activo
                                </span>
                                <span v-else class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-800">
                                    <span class="mr-1.5 h-2 w-2 rounded-full bg-gray-600"></span>
                                    Inactivo
                                </span>

                                <!-- Categoría -->
                                <span class="inline-flex w-fit items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    @{{ record.category_name ?? 'Sin categoría' }}
                                </span>

                                <!-- Tipo -->
                                <span class="text-xs text-gray-600 dark:text-gray-400">
                                    @{{ record.type }}
                                </span>
                            </div>

                            <!-- Acciones -->
                            <div class="flex items-center gap-1">
                                <span
                                    class="cursor-pointer rounded-md p-2 text-2xl transition-all hover:bg-blue-100 dark:hover:bg-gray-800"
                                    :class="action.icon"
                                    v-text="! action.icon ? action.title : ''"
                                    v-for="action in record.actions"
                                    @click="performAction(action)"
                                >
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    </x-admin::datagrid>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-create-product-form-template"
        >
            <div>
                <!-- Product Create Button -->
                @if (bouncer()->hasPermission('catalog.products.create'))
                    <button
                        type="button"
                        class="primary-button flex items-center gap-2"
                        @click="$refs.productCreateModal.toggle()"
                    >
                        <span class="icon-add text-lg"></span>
                        Nuevo Producto
                    </button>
                @endif

                <x-admin::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, create)">
                        <!-- Customer Create Modal -->
                        <x-admin::modal ref="productCreateModal">
                            <!-- Modal Header -->
                            <x-slot:header>
                                <p
                                    class="text-lg font-bold text-gray-800 dark:text-white"
                                    v-if="! attributes.length"
                                >
                                    Crear Nuevo Producto - Colegio Meze
                                </p>

                                <p
                                    class="text-lg font-bold text-gray-800 dark:text-white"
                                    v-else
                                >
                                    @lang('admin::app.catalog.products.index.create.configurable-attributes')
                                </p>
                            </x-slot>

                            <!-- Modal Content -->
                            <x-slot:content>
                                <div v-show="! attributes.length">
                                    {!! view_render_event('bagisto.admin.catalog.products.create_form.general.controls.before') !!}

                                    <!-- Product Type -->
                                    <x-admin::form.control-group>
                                        <x-admin::form.control-group.label class="required">
                                            Tipo de Producto
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="select"
                                            name="type"
                                            rules="required"
                                            :label="trans('admin::app.catalog.products.index.create.type')"
                                        >
                                            @foreach(config('product_types') as $key => $type)
                                                <option value="{{ $key }}">
                                                    @lang($type['name'])
                                                </option>
                                            @endforeach
                                        </x-admin::form.control-group.control>

                                        <x-admin::form.control-group.error control-name="type" />
                                    </x-admin::form.control-group>

                                    <!-- Attribute Family Id -->
                                    <x-admin::form.control-group>
                                        <x-admin::form.control-group.label class="required">
                                            Familia de Atributos
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="select"
                                            name="attribute_family_id"
                                            rules="required"
                                            :label="trans('admin::app.catalog.products.index.create.family')"
                                        >
                                            @foreach($families as $family)
                                                <option value="{{ $family->id }}">
                                                    {{ $family->name }}
                                                </option>
                                            @endforeach
                                        </x-admin::form.control-group.control>

                                        <x-admin::form.control-group.error control-name="attribute_family_id" />
                                    </x-admin::form.control-group>

                                    <!-- SKU -->
                                    <x-admin::form.control-group>
                                        <x-admin::form.control-group.label class="required">
                                            SKU
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="sku"
                                            ::rules="{ required: true, regex: /^[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*$/ }"
                                            :label="trans('admin::app.catalog.products.index.create.sku')"
                                            placeholder="Ej: CAMISA-NIÑO-M"
                                        />

                                        <x-admin::form.control-group.error control-name="sku" />
                                    </x-admin::form.control-group>

                                    {!! view_render_event('bagisto.admin.catalog.products.create_form.general.controls.after') !!}
                                </div>

                                <div v-show="attributes.length">
                                    {!! view_render_event('bagisto.admin.catalog.products.create_form.attributes.controls.before') !!}

                                    <div
                                        class="mb-2.5"
                                        v-for="attribute in attributes"
                                    >
                                        <label
                                            class="block text-xs font-medium leading-6 text-gray-800 dark:text-white"
                                            v-text="attribute.name"
                                        >
                                        </label>

                                        <div class="flex min-h-[38px] flex-wrap gap-1 rounded-md border p-1.5 dark:border-gray-800">
                                            <p
                                                class="flex items-center rounded bg-gray-600 px-2 py-1 font-semibold text-white"
                                                v-for="option in attribute.options"
                                            >
                                                @{{ option.name }}

                                                <span
                                                    class="icon-cross cursor-pointer text-lg text-white ltr:ml-1.5 rtl:mr-1.5"
                                                    @click="removeOption(option)"
                                                >
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    {!! view_render_event('bagisto.admin.catalog.products.create_form.attributes.controls.after') !!}
                                </div>
                            </x-slot>

                            <!-- Modal Footer -->
                            <x-slot:footer>
                                <div class="flex items-center gap-x-2.5">
                                    <!-- Back Button -->
                                    <button
                                        type="button"
                                        class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                                        v-if="attributes.length"
                                        @click="attributes = []"
                                    >
                                        Atrás
                                    </button>

                                    <!-- Save Button -->
                                    <button
                                        type="submit"
                                        class="primary-button"
                                        :disabled="isLoading"
                                    >
                                        <span v-if="!isLoading">Guardar Producto</span>
                                        <span v-else>Guardando...</span>
                                    </button>
                                </div>
                            </x-slot>
                        </x-admin::modal>
                    </form>
                </x-admin::form>
            </div>
        </script>

        <script type="module">
            app.component('v-create-product-form', {
                template: '#v-create-product-form-template',

                data() {
                    return {
                        attributes: [],
                        superAttributes: {},
                        isLoading: false,
                    };
                },

                methods: {
                    create(params, { resetForm, resetField, setErrors }) {
                        this.isLoading = true;

                        this.attributes.forEach(attribute => {
                            params.super_attributes ||= {};
                            params.super_attributes[attribute.code] = this.superAttributes[attribute.code];
                        });

                        this.$axios.post("{{ route('admin.catalog.products.store') }}", params)
                            .then((response) => {
                                this.isLoading = false;

                                if (response.data.data.redirect_url) {
                                    window.location.href = response.data.data.redirect_url;
                                } else {
                                    this.attributes = response.data.data.attributes;
                                    this.setSuperAttributes();
                                }
                            })
                            .catch(error => {
                                this.isLoading = false;

                                if (error.response.status == 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },

                    removeOption(option) {
                        this.attributes.forEach(attribute => {
                            attribute.options = attribute.options.filter(item => item.id != option.id);
                        });

                        this.attributes = this.attributes.filter(attribute => attribute.options.length > 0);
                        this.setSuperAttributes();
                    },

                    setSuperAttributes() {
                        this.superAttributes = {};

                        this.attributes.forEach(attribute => {
                            this.superAttributes[attribute.code] = [];

                            attribute.options.forEach(option => {
                                this.superAttributes[attribute.code].push(option.id);
                            });
                        });
                    }
                }
            });

            app.component('v-category-filter', {
                template: '<div></div>',
            });
        </script>
    @endPushOnce
</x-admin::layouts>