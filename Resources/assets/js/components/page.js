const Page = (() => {
    
    function addBlockRequest(page, blockId)
    {
        let uri = Config.get('page.uris.addBlock');
        uri = Helpers.replaceUriSlugs(uri, [page, blockId]);
        return Helpers.post(uri);
    }

    function deleteBlockRequest(page, blockId)
    {
        let uri = Config.get('page.uris.deleteBlock');
        uri = Helpers.replaceUriSlugs(uri, [page, blockId]);
        return Helpers._delete(uri);
    }

    return {
        addBlockRequest: addBlockRequest,
        deleteBlockRequest: deleteBlockRequest
    };

})();

export default Page;