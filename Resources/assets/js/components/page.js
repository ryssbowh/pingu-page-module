const Page = (() => {
    
    function addBlockRequest(page, blockId)
    {
        let uri = Config.get('page.uris.addBlock');
        uri = Helpers.replaceUriSlugs(uri, [page, blockId]);
        return Helpers.post(uri);
    }

    return {
        addBlockRequest: addBlockRequest
    };

})();

export default Page;