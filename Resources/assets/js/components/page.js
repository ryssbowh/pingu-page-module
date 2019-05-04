import * as h from 'helpers';

const Page = (() => {

	let options = {
		addBlock : $('.js-add-block')
	};

	function init(){ 
		console.log('Page initialized');
	};

	function getCreateBlockForm(provider){
		return h.post('/api/blocks/create/'+provider, {'_setTheme': 'admin'});
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