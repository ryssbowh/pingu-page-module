import * as h from 'pingu-helpers';

const Page = (() => {

	let options = {
		addBlock : $('.js-add-block')
	};

	function init(){ 
		console.log('Page initialized');
	};

	function getCreateBlockForm(provider, theme){
		return h.get('/api/blocks/create/'+provider, {'_theme': theme});
	}

	function listBlocksForPage(page){
		return h.post('/api/page/'+page+'/blocks');
	}

	return {
		init: init,
		getCreateBlockForm: getCreateBlockForm,
		listBlocksForPage: listBlocksForPage
	};

})();

export default Page;