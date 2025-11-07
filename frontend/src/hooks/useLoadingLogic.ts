import { useState,useCallback } from "react";

export const useLoadingLogic = () => {
    const [isLoading, setIsLoading] = useState(false);

    const open = useCallback(() => setIsLoading(true), []);
    const close = useCallback(() => setIsLoading(false), []);

    return { open, close, isLoading };
}