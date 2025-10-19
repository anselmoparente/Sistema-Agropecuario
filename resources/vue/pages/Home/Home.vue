<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import Card from 'primevue/card';
import Chart from 'primevue/chart';
import VueApexCharts from 'vue3-apexcharts';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    totalProdutores: Number,
    totalPropriedades: Number,
    totalAnimais: Number,
    totalHectares: Number,
    ultimosProdutores: Array,
    ultimasPropriedades: Array,
    propriedadesPorMunicipio: Array,
    animaisPorEspecie: Array,
    hectaresPorCultura: Array,
});

const formattedHectares = computed(() => {
    return props.totalHectares.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
});

const propriedadesChartData = computed(() => {
    const labels = props.propriedadesPorMunicipio.map(item => item.municipio);
    const series = props.propriedadesPorMunicipio.map(item => item.total);
    return {
        labels,
        datasets: [
            {
                label: 'Total de Propriedades',
                data: series,
                backgroundColor: ['#42A5F5', '#66BB6A', '#FFA726', '#26C6DA', '#7E57C2'],
                hoverBackgroundColor: ['#64B5F6', '#81C784', '#FFB74D', '#4DD0E1', '#9575CD']
            }
        ]
    };
});

const animaisChartData = computed(() => {
    const labels = props.animaisPorEspecie.map(item => item.especie);
    const series = props.animaisPorEspecie.map(item => item.total);
    return {
        labels,
        datasets: [
            {
                label: 'Total de Animais',
                data: series,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }
        ]
    };
});

const hectaresChartOptions = computed(() => ({
    chart: { type: 'bar', height: 350, toolbar: { show: false } },
    plotOptions: { bar: { horizontal: true, } },
    xaxis: { categories: props.hectaresPorCultura.map(item => item.nome_cultura) },
    title: { text: 'Total de Hectares por Cultura', align: 'center' }
}));

const hectaresChartSeries = computed(() => [{
    name: 'Hectares',
    data: props.hectaresPorCultura.map(item => parseFloat(item.total).toFixed(2))
}]);

const chartOptions = {
    plugins: {
        legend: {
            labels: { usePointStyle: true }
        }
    }
};

</script>

<template>

    <Head title="Dashboard" />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <Card class="shadow-md hover:shadow-xl transition-shadow duration-300">
            <template #content>
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <i class="pi pi-users text-2xl text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total de Produtores</p>
                        <p class="text-2xl font-bold text-gray-800">{{ totalProdutores }}</p>
                    </div>
                </div>
            </template>
        </Card>
        <Card class="shadow-md hover:shadow-xl transition-shadow duration-300">
            <template #content>
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <i class="pi pi-map-marker text-2xl text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total de Propriedades</p>
                        <p class="text-2xl font-bold text-gray-800">{{ totalPropriedades }}</p>
                    </div>
                </div>
            </template>
        </Card>
        <Card class="shadow-md hover:shadow-xl transition-shadow duration-300">
            <template #content>
                <div class="flex items-center">
                    <div class="p-3 bg-orange-100 rounded-full mr-4">
                        <i class="pi pi-prime text-2xl text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total de Animais</p>
                        <p class="text-2xl font-bold text-gray-800">{{ totalAnimais }}</p>
                    </div>
                </div>
            </template>
        </Card>
        <Card class="shadow-md hover:shadow-xl transition-shadow duration-300">
            <template #content>
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full mr-4">
                        <i class="pi pi-th-large text-2xl text-purple-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total de Hectares</p>
                        <p class="text-2xl font-bold text-gray-800">{{ formattedHectares }} ha</p>
                    </div>
                </div>
            </template>
        </Card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <Card class="shadow-lg">
            <template #title>
                <h2 class="text-xl font-bold text-gray-800 text-center">Propriedades por Município</h2>
            </template>
            <template #content>
                <div class="flex justify-center p-4">
                    <Chart type="pie" :data="propriedadesChartData" :options="chartOptions" class="w-full md:w-30rem" />
                </div>
            </template>
        </Card>

        <Card class="shadow-lg">
            <template #title>
                <h2 class="text-xl font-bold text-gray-800 text-center">Animais por Espécie</h2>
            </template>
            <template #content>
                <div class="flex justify-center p-4">
                    <Chart type="doughnut" :data="animaisChartData" :options="chartOptions" class="w-full md:w-30rem" />
                </div>
            </template>
        </Card>

        <div class="lg:col-span-2">
            <Card class="shadow-lg">
                <template #content>
                    <VueApexCharts :options="hectaresChartOptions" :series="hectaresChartSeries" type="bar"
                        height="350" />
                </template>
            </Card>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <Card class="shadow-lg">
            <template #title>
                <h2 class="text-xl font-bold text-gray-800">Últimos Produtores Cadastrados</h2>
            </template>
            <template #content>
                <ul class="space-y-4">
                    <li v-for="produtor in ultimosProdutores" :key="produtor.id">
                        <Link :href="route('produtores.show', produtor.id)"
                            class="block hover:bg-gray-50 p-3 rounded-md transition-colors duration-200">
                        <p class="font-semibold text-gray-700">{{ produtor.nome }}</p>
                        <p class="text-sm text-gray-500">{{ produtor.cpf_cnpj }}</p>
                        </Link>
                    </li>
                </ul>
            </template>
        </Card>
        <Card class="shadow-lg">
            <template #title>
                <h2 class="text-xl font-bold text-gray-800">Últimas Propriedades Adicionadas</h2>
            </template>
            <template #content>
                <ul class="space-y-4">
                    <li v-for="propriedade in ultimasPropriedades" :key="propriedade.id">
                        <Link :href="route('propriedades.show', propriedade.id)"
                            class="block hover:bg-gray-50 p-3 rounded-md transition-colors duration-200">
                        <p class="font-semibold text-gray-700">{{ propriedade.nome }}</p>
                        <p class="text-sm text-gray-500">de {{ propriedade.produtor.nome }}</p>
                        </Link>
                    </li>
                </ul>
            </template>
        </Card>
    </div>
</template>
