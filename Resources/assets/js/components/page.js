import * as h from 'helpers';

const Page = (() => {

	let options = {
		addBlock : $('.js-add-block')
	};

	function init(){ 
		console.log('Page initialized');
	};

	function getCreateBlockForm(provider){
		return h.ajax('/api/blocks/create/'+provider, {'_isAdmin': true});
	}

	return {
		init: init,
		getCreateBlockForm: getCreateBlockForm
	};

})();

export default Page;