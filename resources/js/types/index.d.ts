import {TYPE} from "vue-toastification";

export interface User {
    id: number;
    username: string;
    email: string;
    name: string;
    surname: string;
    phone: string;
}

export interface Role {
    id?: number;
    name: string;
    is_admin: boolean;
}

export type Toast = string | {
    type: TYPE,
    message: string,
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        role: Role;
    },
    toast: Toast,
};
