function DsRemote(url) {
    this.url = url;
    this.data = [];
    this.buffer = 10;
    this.position = 0;
    this.page = 0;
    this.totalPages = 0;
    this.size = 0;
    this.filter = '';
    
    
    this.post = ()=>{
        
    };
    this.delete = ()=>{
        
    };
    this.insert = (data)=>{
        
    }
    this.load = () => {
        this._calc_page();
        //@TODO: implementar filtro
        fetch(url + `?offset=${this.position}&buffer=${this.buffer}&filter=${this.filter}`).then(r => r.json()).then(json => {
            this.size = json.size;
            this.data = json.data;
            this._calc_page();
        })
    }
    this._calc_page = () => {
        var page = this.position / this.buffer;
        if (this.data.length > 0 && this.size > 0)
            this.totalPages = this.size / this.buffer;
        return this.page = parseInt(page.toString().split(/\./)[0]);
    }
    this.moveNext = () => {
        if (this.position % this.buffer == 0)
            this.load();
        this.position++;
    };
    this.movePrevious = () => {
        this.position--;
        if (this.position % this.buffer == 0)
            this.load();
    };
    this.moveNextPage = () => {
        this.position = (this._calc_page() + 1) * this.buffer;
        this.load();
    };
    this.movePreviousPage = () => {
        this.position = (this._calc_page() - 1) * this.buffer;
        this.load();
    };
}
