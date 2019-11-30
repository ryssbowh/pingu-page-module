import * as h from 'PinguHelpers';

const Page = (() => {

	function init(){ 
		h.log('Page initialized');
	};

    function addBlockRequest(page, blockId)
    {
        let uri = h.config('page.uris.addBlock');
        uri = h.replaceUriSlugs(uri, [page, blockId]);
        return h.post(uri);
    }

	return {
		init: init,
        addBlockRequest: addBlockRequest
	};

})();

export default Page;