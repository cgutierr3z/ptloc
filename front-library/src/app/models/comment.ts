export class Comment {
    constructor(
        public id: number,
        public user_id: number,
        public book_id: number,
        public comment: string,
        public created_at: any
    ) { }
}