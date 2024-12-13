import React, { useState, useEffect } from 'react';

const SearchInput = () => {
    const [searchTerm, setSearchTerm] = useState('');
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleSearch = async (term) => {
        if (term.length === 0) {
            setResults([]);
            return;
        }
        setLoading(true);
        try {
            const response = await fetch(`/api/search?query=${term}`);
            if (response.ok) {
                const data = await response.json();
                setResults(data.results);
            } else {
                console.error('Error fetching search results:', response.statusText);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleProduct = (id) => {
        window.location.href = `${window.location.origin}/products/${id}`;
    };

    const handleKeyPress = (event) => {
        if (event.key === 'Enter') {
            console.log(searchTerm)
            window.location.href = `/search-results?query=${encodeURIComponent(searchTerm)}`;
        }
    };

    useEffect(() => {
        const delayDebounceFn = setTimeout(() => {
            handleSearch(searchTerm);
        }, 300);

        return () => clearTimeout(delayDebounceFn);
    }, [searchTerm]);

    return (
        <div className="relative w-full max-w-lg mx-auto mr-2">
            <input
                type="text"
                placeholder="Tìm kiếm..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                onKeyPress={handleKeyPress}
                className="w-full border border-gray-300 rounded-full py-2 px-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:border-green-500 transition duration-300 ease-in-out shadow-sm"
            />

            {loading && <p className="mt-2 text-gray-500">Đang tìm kiếm...</p>}

            {results.length > 0 && (
                <ul className="absolute bg-white shadow-lg border border-gray-300 rounded-lg mt-2 w-full max-h-60 overflow-auto z-10">
                    {results.map((result) => (
                        <li
                            key={result.id}
                            className="flex items-center px-4 py-3 hover:bg-green-50 cursor-pointer transition-all duration-200 ease-in-out"
                            onClick={() => handleProduct(result.id)}
                        >
                            <img src={`storage/${result.image}`} alt={result.name} className="w-10 h-10 mr-3" />
                            <div className="flex-1">
                                <p className="text-sm font-medium text-gray-900">{result.name}</p>
                                <p className="text-xs text-gray-500">{result.description.length > 50 ? `${result.description.substring(0, 50)}...` : result.description}</p>

                            </div>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
};

export default SearchInput;
