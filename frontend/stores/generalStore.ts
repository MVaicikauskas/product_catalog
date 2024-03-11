import {defineStore} from "pinia";
import type {IGeneralStateInterface} from "~/stores/interfaces/IGeneralState.interface";



export const generalStore = defineStore('general', {
    state: (): IGeneralStateInterface => ({
        categories: [],
        colors: [],
        sizes: [],
        brands: [],
    }),
})