# Preparing Data

```py
import re

from nltk import word_tokenize
from nltk.corpus import stopwords

from opensearchpy import OpenSearch
from opensearchpy.helpers import bulk

es = OpenSearch(
    hosts=[{
        'host': 'vpc-bop-storefront-search-feqwt6lxposid3cx2l355uxtgm.us-east-1.es.amazonaws.com',
        'port': 443,
    }],
    use_ssl=True,
    verify_certs=True,
)


# nltk.download(['stopwords', 'punkt'])


def shingle(text, n_min=2, n_max=3, min_characters=2):
    stop_words = set(stopwords.words('english'))
    text = re.sub("[\\'\"\\(\\)\\[\\]\\{\\}\\.\\,\\&\\:]", "", text)

    word_tokens = word_tokenize(text)
    word_tokens = [w for w in word_tokens if not w.lower() in stop_words]
    word_tokens = [w.lower() for w in word_tokens if len(w) > min_characters]
    total = len(word_tokens)

    output = []
    for k in range(n_min, n_max + 1):
        sub_input = []
        for i in range(total - k + 1):
            sub_input.append(' '.join(word_tokens[i:(i + k)]))
        output.append(set(sub_input))

    return set.union(*output)


def prepare_id(id):
    return id.replace(' ', '_')


def iterate(index, pagesize=1000, scroll_timeout="1m", **kwargs):
    """
    Helper to iterate ALL values from a single index
    Yields all the documents.
    """
    is_first = True
    while True:
        print(".")
        # Scroll next
        if is_first:  # Initialize scroll
            result = es.search(index=index, scroll="1m", **kwargs, body={
                "size": pagesize,
                '_source': ['mlrId', 'title', 'product_title']
            })
            is_first = False
        else:
            result = es.scroll(body={
                "scroll_id": scroll_id,
                "scroll": scroll_timeout
            })
        scroll_id = result["_scroll_id"]
        hits = result["hits"]["hits"]
        # Stop after no more docs
        if not hits:
            break
        # Yield each entry
        yield from (hit['_source'] for hit in hits)


if __name__ == '__main__':
    total_count = 0
    bulk_data = []
    for item in iterate('storefront-denormalized-index'):
        title = ''
        if 'title' in item.keys():
            title = item['title']
        elif 'product_title' in item.keys():
            title = item['product_title']
        else:
            print('Skipped MLrId : ' + item['mlrId'])
            continue
        tokens = shingle(title)
        for token in tokens:
            bulk_data.append({
                "_index": "poc-title-suggestor-03.04",
                "_id": prepare_id(token),
                "_source": {
                    "title": title,
                    'mlrId': item['mlrId'],
                    'token': token,
                }
            })
        if len(bulk_data) > 1000:
            bulk(es, bulk_data)
            bulk_data = []
            total_count += 1000
            print(total_count)
        

```