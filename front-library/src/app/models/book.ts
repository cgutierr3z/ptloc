export class Book {
    constructor(
        public id: number,
        public user_id: number,
        public title: string,
        public author: string,
        public description: string,
        public image: string,
        public status: string,
        public no_comments: number,
        public created_at: any
    ) { }
}