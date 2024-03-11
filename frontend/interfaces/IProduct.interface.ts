import type {IBrand} from "~/interfaces/IBrand.interface";
import type {ICategory} from "~/interfaces/ICategory.interface";

export interface IProduct {
    id: string;
    title: string;
    price: number;
    stock: number;
    model: string;
    image_url: string;
    product_url: string;
    delivery_price: number;
    delivery_time: string;
    condition: string;
    brand_name: string;
    category_title: string;
    category: string | ICategory;
    category_id: number;
    brand: string | IBrand;
    brand_id: number;
}