export function SkeletonMediaList() {
    const skeletons = Array.from({ length: 12 });

    return (
        <div className="media-library row">
            {skeletons.map((_, index) => (
                <div key={index} className="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
                    <div
                        className="file-wrap"
                        style={{
                            minHeight: '140px',
                            backgroundColor: '#f4f5f7',
                            borderRadius: '8px',
                            padding: '10px',
                            animation: 'pulse 1.5s infinite ease-in-out'
                        }}
                    >
                        <div style={{
                            height: '90px',
                            backgroundColor: '#e2e5ea',
                            borderRadius: '4px',
                            marginBottom: '10px'
                        }}></div>
                        <div style={{
                            height: '16px',
                            backgroundColor: '#e2e5ea',
                            borderRadius: '4px',
                            width: '70%',
                            margin: '0 auto'
                        }}></div>
                    </div>
                </div>
            ))}

            <style>{`
                    @keyframes pulse {
                        0% { opacity: 1; }
                        50% { opacity: 0.5; }
                        100% { opacity: 1; }
                    }
                `}</style>
        </div>
    );
}
