const Page = (() => {

    function init()
    { 
        h.log('Page initialized');
    };

    function addBlockRequest(page, blockId)
    {
        let uri = Config.config('page.uris.addBlock');
        uri = Helpers.replaceUriSlugs(uri, [page, blockId]);
        return Helpers.post(uri);
    }

    return {
        init: init,
        addBlockRequest: addBlockRequest
    };

})();

export default Page;