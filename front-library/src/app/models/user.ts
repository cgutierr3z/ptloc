export class User {
    constructor(
        public id: number,
        public name: string,
        public surname: string,
        public role: string,
        public avatar: string,
        public email: string,
        public password: string
    ) { }
}