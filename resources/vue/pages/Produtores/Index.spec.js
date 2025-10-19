import { describe, it, expect, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import Index from './Index.vue';

import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import DataTable from 'primevue/datatable';


vi.mock('@inertiajs/vue3', async () => {
    const actual = await vi.importActual('@inertiajs/vue3');
    return {
        ...actual,
        Head: { template: '<title><slot/></title>' },
        Link: { template: '<a><slot/></a>' },
        useForm: () => ({ delete: vi.fn() }),
        router: { get: vi.fn() }
    };
});

describe('Produtores/Index.vue', () => {
    const mockProdutores = {
        data: [
            { id: 1, nome: 'Anselmo Teste', cpf_cnpj: '111.111.111-11' },
            { id: 2, nome: 'Maria da Silva', cpf_cnpj: '222.222.222-22' },
        ],
    };

    const mountComponent = (produtoresProp) => {
        return mount(Index, {
            props: {
                produtores: produtoresProp,
                filters: { q: '' },
            },
            global: {
                plugins: [PrimeVue, ConfirmationService, ToastService],
                stubs: {
                    DataTable: {
                        props: ['value'],
                        template: `
                            <div>
                                <div v-if="!value || value.length === 0"><slot name="empty" /></div>
                            </div>
                        `,
                    },
                    ConfirmDialog: true,
                    Column: true,
                },
                mocks: {
                    route: () => '/',
                }
            },
        });
    };

    it('passes the correct producers data to the DataTable component', () => {
        const wrapper = mountComponent(mockProdutores);

        const dataTableComponent = wrapper.findComponent(DataTable);

        expect(dataTableComponent.props('value')).toEqual(mockProdutores.data);
    });

    it('displays an empty message when no producers are available', () => {
        const wrapper = mountComponent({ data: [] });

        expect(wrapper.text()).toContain('Nenhum produtor encontrado.');
    });
});

